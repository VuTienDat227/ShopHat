<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $orderItems;
    public $order;

    public function __construct($orderItems,$order)
    {
        $this->orderItems = $orderItems;
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject('Chi tiết đơn hàng')
            ->view('order_email');
    }
}
