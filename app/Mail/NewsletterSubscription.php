<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterSubscription extends Mailable
{
    use Queueable, SerializesModels;

    public $subscriberEmail;

    /**
     * Create a new message instance.
     */
    public function __construct($subscriberEmail = null)
    {
        $this->subscriberEmail = $subscriberEmail;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        if ($this->subscriberEmail) {
            // Email to admin
            return $this->subject('New Newsletter Subscription')
                       ->markdown('emails.newsletter.admin')
                       ->with(['email' => $this->subscriberEmail]);
        }

        // Email to subscriber
        return $this->subject('Welcome to PhpForge Newsletter')
                   ->markdown('emails.newsletter.subscription');
    }
}
