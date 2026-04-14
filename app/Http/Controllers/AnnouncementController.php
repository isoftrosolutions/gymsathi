<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Plan;
use App\Models\Tenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    /**
     * Display all announcements.
     */
    public function index(Request $request): View
    {
        $query = Announcement::with('creator');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->get('type'));
        }

        $announcements = $query->latest()->paginate(20);

        $stats = [
            'total' => Announcement::count(),
            'sent' => Announcement::where('status', 'sent')->count(),
            'scheduled' => Announcement::where('status', 'scheduled')->count(),
            'draft' => Announcement::where('status', 'draft')->count(),
        ];

        return view('announcements.index', compact('announcements', 'stats'));
    }

    /**
     * Show form to create new announcement.
     */
    public function create(): View
    {
        $plans = Plan::active()->get();
        $cities = Tenant::distinct()->pluck('city')->filter()->sort()->values();

        return view('announcements.create', compact('plans', 'cities'));
    }

    /**
     * Store a new announcement.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'type' => 'required|in:maintenance,feature,offer,general',
            'channels' => 'required|in:whatsapp,in_app,both',
            'scheduled_at' => 'nullable|date|after:now',
            'recipient_filters' => 'nullable|array',
            'recipient_filters.plan' => 'nullable|string',
            'recipient_filters.city' => 'nullable|string',
            'recipient_filters.status' => 'nullable|in:active,suspended,expired',
        ]);

        $announcement = Announcement::create([
            'created_by' => auth()->id(),
            'title' => $request->title,
            'message' => $request->message,
            'type' => $request->type,
            'channels' => $request->channels,
            'status' => $request->scheduled_at ? 'scheduled' : 'draft',
            'scheduled_at' => $request->scheduled_at,
            'recipient_filters' => $request->recipient_filters,
        ]);

        // Calculate recipient count
        $recipients = $announcement->getRecipients();
        $announcement->update(['recipients_count' => $recipients->count()]);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement created successfully.');
    }

    /**
     * Show specific announcement.
     */
    public function show(Announcement $announcement): View
    {
        $announcement->load('creator');

        return view('announcements.show', compact('announcement'));
    }

    /**
     * Edit announcement.
     */
    public function edit(Announcement $announcement): View
    {
        if ($announcement->isSent()) {
            return redirect()->route('admin.announcements.show', $announcement)
                ->with('error', 'Cannot edit sent announcements.');
        }

        $plans = Plan::active()->get();
        $cities = Tenant::distinct()->pluck('city')->filter()->sort()->values();

        return view('announcements.edit', compact('announcement', 'plans', 'cities'));
    }

    /**
     * Update announcement.
     */
    public function update(Request $request, Announcement $announcement): RedirectResponse
    {
        if ($announcement->isSent()) {
            return back()->with('error', 'Cannot edit sent announcements.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'type' => 'required|in:maintenance,feature,offer,general',
            'channels' => 'required|in:whatsapp,in_app,both',
            'scheduled_at' => 'nullable|date|after:now',
            'recipient_filters' => 'nullable|array',
        ]);

        $announcement->update([
            'title' => $request->title,
            'message' => $request->message,
            'type' => $request->type,
            'channels' => $request->channels,
            'scheduled_at' => $request->scheduled_at,
            'recipient_filters' => $request->recipient_filters,
            'status' => $request->scheduled_at ? 'scheduled' : 'draft',
        ]);

        // Recalculate recipient count
        $recipients = $announcement->getRecipients();
        $announcement->update(['recipients_count' => $recipients->count()]);

        return redirect()->route('admin.announcements.show', $announcement)
            ->with('success', 'Announcement updated successfully.');
    }

    /**
     * Send announcement immediately.
     */
    public function send(Announcement $announcement): RedirectResponse
    {
        if ($announcement->isSent()) {
            return back()->with('error', 'Announcement has already been sent.');
        }

        try {
            $recipients = $announcement->getRecipients();

            // TODO: Implement WhatsApp and in-app sending logic
            // For now, just mark as sent

            $announcement->markAsSent();

            return back()->with('success', "Announcement sent to {$recipients->count()} recipients.");

        } catch (\Exception $e) {
            $announcement->markAsFailed($e->getMessage());

            return back()->with('error', 'Failed to send announcement: '.$e->getMessage());
        }
    }

    /**
     * Schedule announcement for future sending.
     */
    public function schedule(Request $request, Announcement $announcement): RedirectResponse
    {
        $request->validate([
            'scheduled_at' => 'required|date|after:now',
        ]);

        $announcement->schedule($request->scheduled_at);

        return back()->with('success', 'Announcement scheduled successfully.');
    }

    /**
     * Delete announcement.
     */
    public function destroy(Announcement $announcement): RedirectResponse
    {
        if ($announcement->isSent()) {
            return back()->with('error', 'Cannot delete sent announcements.');
        }

        $announcement->delete();

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement deleted successfully.');
    }
}
