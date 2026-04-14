<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupportController extends Controller
{
    /**
     * Display support dashboard with all tickets.
     */
    public function index(Request $request): View
    {
        $query = SupportTicket::with(['tenant', 'creator', 'assignedAdmin']);

        // Search by subject or tenant name
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                    ->orWhereHas('tenant', function ($tenantQuery) use ($search) {
                        $tenantQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->get('priority'));
        }

        // Filter by assigned admin
        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->get('assigned_to'));
        }

        // Sort by priority first, then by creation date
        $query->orderByRaw("FIELD(priority, 'urgent', 'high', 'medium', 'low')")
            ->orderBy('created_at', 'desc');

        $tickets = $query->paginate(20);

        // Get stats for dashboard
        $stats = [
            'total' => SupportTicket::count(),
            'open' => SupportTicket::whereIn('status', ['open', 'in_progress'])->count(),
            'urgent' => SupportTicket::where('priority', 'urgent')->whereIn('status', ['open', 'in_progress'])->count(),
            'unassigned' => SupportTicket::whereNull('assigned_to')->whereIn('status', ['open', 'in_progress'])->count(),
        ];

        $admins = User::where('platform_role', 'admin')->get();

        return view('support.index', compact('tickets', 'stats', 'admins'));
    }

    /**
     * Show a specific support ticket.
     */
    public function show(SupportTicket $ticket): View
    {
        $ticket->load(['tenant', 'creator', 'assignedAdmin', 'messages.user']);

        return view('support.show', compact('ticket'));
    }

    /**
     * Assign ticket to admin.
     */
    public function assign(Request $request, SupportTicket $ticket): RedirectResponse
    {
        $request->validate([
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $ticket->assignTo($request->assigned_to ? User::find($request->assigned_to) : null);

        $message = $request->assigned_to
            ? 'Ticket assigned successfully.'
            : 'Ticket unassigned successfully.';

        return back()->with('success', $message);
    }

    /**
     * Update ticket priority.
     */
    public function updatePriority(Request $request, SupportTicket $ticket): RedirectResponse
    {
        $request->validate([
            'priority' => 'required|in:low,medium,high,urgent',
        ]);

        $ticket->updatePriority($request->priority);

        return back()->with('success', 'Priority updated successfully.');
    }

    /**
     * Add reply to ticket.
     */
    public function reply(Request $request, SupportTicket $ticket): RedirectResponse
    {
        $request->validate([
            'message' => 'required|string|min:1|max:2000',
            'is_internal' => 'boolean',
        ]);

        // Create the message
        $ticket->messages()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
            'is_internal' => $request->boolean('is_internal', false),
            'is_from_admin' => true,
        ]);

        // If this is the first admin reply, mark ticket as in progress
        if ($ticket->isOpen()) {
            $ticket->markInProgress();
        }

        // TODO: Send WhatsApp notification to gym owner if not internal

        return back()->with('success', 'Reply sent successfully.');
    }

    /**
     * Mark ticket as resolved.
     */
    public function resolve(SupportTicket $ticket): RedirectResponse
    {
        if (! $ticket->isInProgress()) {
            return back()->with('error', 'Only tickets in progress can be resolved.');
        }

        $ticket->markResolved();

        // TODO: Send WhatsApp notification to gym owner

        return back()->with('success', 'Ticket marked as resolved.');
    }

    /**
     * Reopen a resolved ticket.
     */
    public function reopen(SupportTicket $ticket): RedirectResponse
    {
        if (! $ticket->isResolved()) {
            return back()->with('error', 'Only resolved tickets can be reopened.');
        }

        $ticket->update(['status' => 'open', 'resolved_at' => null]);

        return back()->with('success', 'Ticket reopened successfully.');
    }

    /**
     * Close a resolved ticket.
     */
    public function close(SupportTicket $ticket): RedirectResponse
    {
        if (! $ticket->isResolved()) {
            return back()->with('error', 'Only resolved tickets can be closed.');
        }

        $ticket->markClosed();

        // TODO: Send WhatsApp notification to gym owner

        return back()->with('success', 'Ticket closed successfully.');
    }

    /**
     * Add internal note to ticket.
     */
    public function addNote(Request $request, SupportTicket $ticket): RedirectResponse
    {
        $request->validate([
            'note' => 'required|string|min:1|max:1000',
        ]);

        $ticket->addInternalNote($request->note, auth()->user());

        return back()->with('success', 'Internal note added successfully.');
    }
}
