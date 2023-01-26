<?php

namespace App\Http\Controllers\Interconnection;

use Mail;
use Functions;

trait SmtpTrait
{

    public function SendingMessages($subject, $email, $type, $data = [])
    {
        $data['type'] = $type;
        $environment = Functions::env();
        $send = Mail::send('mails.send_mail', ['data' => $data], function ($message) use ($email, $subject, $environment) {
            $message->to($email)->subject($environment == 'production' ? $subject : '[** ' . $environment . ' **] ' . $subject);
        });
    }
}
