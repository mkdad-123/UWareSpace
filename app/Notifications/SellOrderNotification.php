<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class SellOrderNotification extends Notification
{
    use Queueable;

    public $orderId;

    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    public function via($notifiable): array
    {
        return ['database' , 'App\Channels\FirebaseChannel'];
       // return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'order_id' => $this->orderId,

            'message' => 'New order received'
        ];
    }

    public function toArray($notifiable): array
    {
        return [];
    }

    public function toFirebase($notifiable): array
    {
        return [
            'notification' => [
                'title' => 'New Order',
                'body' => 'You have received a new order!',
                'data' => [
                    'order_id' => $this->orderId
                ]
            ]
        ];
    }
}
