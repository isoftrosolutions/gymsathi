<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class TemplateMail extends Mailable
{
    public $data;

    public $subject;

    public $html;

    /**
     * Create a new message instance.
     */
    public function __construct(string $slug, array $data)
    {
        $this->data = $data;

        // Default global data
        $this->data['institute_name'] = config('app.name', 'GymSathi');
        $this->data['gym_name'] = $data['gym_name'] ?? config('app.name', 'GymSathi');
        $this->data['current_date'] = now()->format('Y-m-d');
        $this->data['login_url'] = url('/login');

        // Try DB first, fall back to gym_templates.php
        $dbTemplate = EmailTemplate::where('slug', $slug)->first();

        if ($dbTemplate) {
            $subject = $dbTemplate->subject;
            $body = $dbTemplate->body;
        } else {
            $templates = require base_path('gym_templates.php');
            if (! isset($templates[$slug])) {
                throw new \InvalidArgumentException("Email template [{$slug}] not found.");
            }
            $subject = $templates[$slug]['subject'];
            $body = $templates[$slug]['body'];
        }

        $this->subject = $this->parseTemplate($subject);
        $this->html = $this->parseTemplate($body);
    }

    protected function parseTemplate($content)
    {
        foreach ($this->data as $key => $value) {
            $content = str_replace('{{'.$key.'}}', $value, $content);
        }

        return $content;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            htmlString: $this->html,
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
