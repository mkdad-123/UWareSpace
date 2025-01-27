<?php

namespace App\Channels;

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

        $factory = (new Factory)->withServiceAccount(storage_path('app/firebase_credentials.json'));

        $messaging = $factory->createMessaging();

        $message = [
            'notification' => $data['notification'],
            //'data' => $data['notification']['data'],
            'token' => $notifiable->routeNotificationFor('firebase'),
        ];

        $messaging->send($message);

    }
}

