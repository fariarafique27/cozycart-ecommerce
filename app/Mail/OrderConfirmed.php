<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public $order; // 🧸 This makes $order available in your template automatically

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your CozyCart Order Confirmation! 🧸📦',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-confirmed', // Points to resources/views/emails/order-confirmed.blade.php
        );
    }
}