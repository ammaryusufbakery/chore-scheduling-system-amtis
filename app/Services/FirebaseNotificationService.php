<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseNotificationService
{
    protected $messaging;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(
                storage_path(
                    'app/firebase/firebase_credentials.json'
                )
            );

        $this->messaging = $factory->createMessaging();
    }

    public function send(
        string $token,
        string $title,
        string $body
    ) {
        $notification = Notification::create(
            $title,
            $body
        );

        $message = CloudMessage::new()
            ->withToken($token)
            ->withNotification($notification);

        return $this->messaging->send($message);
    }
}