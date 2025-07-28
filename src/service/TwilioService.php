<?php

namespace App\Service;

use Twilio\Rest\Client;

class TwilioService {
    private string $sid;
    private string $token;
    private string $from;


    public function sendSMS(string $to, string $message): bool|string {
        try {
            $client = new Client(TWILIO_SID, TWILIO_TOKEN);
            $client->messages->create($to, [
                'from' => TWILIO_FROM,
                'body' => $message
            ]);
            return true;
        } catch (\Exception $e) {
            return $e->getMessage(); 
        }
    }
}
