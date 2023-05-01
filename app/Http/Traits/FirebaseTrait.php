<?php

namespace App\Http\Traits;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Messaging\CloudMessage;

trait FirebaseTrait
{
    public function getCloudMessaging()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/firebase_credentials.json');

        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->createMessaging();

        return $firebase;
    }
    public function  buildNotification($deviceToken,$notificationMessage)
    {
        //$deviceToken = '...';

        $notificationObject['notification']=$notificationMessage;

        $message = CloudMessage::fromArray([
            'token' => $deviceToken,
            'notification' => $notificationObject,
            'data' => [/* data array */], // optional
        ]);

        $this->getCloudMessaging()->send($message);
    }
}
