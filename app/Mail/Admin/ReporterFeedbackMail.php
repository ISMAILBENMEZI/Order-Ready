<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReporterFeedbackMail extends Mailable
{
    use Queueable, SerializesModels;

    public $report;
    public $feedback;

    public function __construct($report, $feedback)
    {
        $this->report = $report;
        $this->feedback = $feedback;
    }

    public function build()
    {
        return $this->subject('Update regarding your recent report')
            ->view('emails.admin.reporter_feedback');
    }
}
