<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderPlacedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public bool $isAdminNotification;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, bool $isAdminNotification = false)
    {
        $this->order = $order;
        $this->isAdminNotification = $isAdminNotification;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->isAdminNotification 
            ? '🔔 নতুন অর্ডার প্রাপ্তি — অর্ডার #' . $this->order->order_number . ' (' . $this->order->customer_name . ')'
            : '🎉 আপনার অর্ডারটি সফলভাবে গ্রহণ করা হয়েছে — অর্ডার #' . $this->order->order_number;

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order-placed',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
