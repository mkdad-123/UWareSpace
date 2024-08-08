<?php

namespace App\Channels;

use App\Notifications\SellOrderNotification;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Factory;

class FirebaseChannel
{
    /**
     * @throws \Kreait\Firebase\Exception\MessagingException
     * @throws \Kreait\Firebase\Exception\FirebaseException
     */

    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toFirebase($notifiable);

        $factory = (new Factory)->withServiceAccount(config('firebase_credentials'));
        $messaging = $factory->createMessaging();

        $message = [
            'notification' => $data['notification'],
            'data' => $data['data'],
            'token' => $notifiable->routeNotificationFor('firebase'),
        ];

        $messaging->send($message);
    }
}

