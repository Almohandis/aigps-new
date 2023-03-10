<?php

namespace App\Http\Controllers;

use App\Mail\RegisterEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegisterEmailController extends Controller
{
    protected $token;
    public function sendEmail($token)
    {
        $this->token = $token;
        /**
         * Store a receiver email address to a variable.
         */
        $reveiverEmailAddress = "clash26142@gmail.com";

        /**
         * Import the Mail class at the top of this page,
         * and call the to() method for passing the
         * receiver email address.
         *
         * Also, call the send() method to incloude the
         * HelloEmail class that contains the email template.
         */
        Mail::to($reveiverEmailAddress)->send(new RegisterEmail($this->token));

        /**
         * Check if the email has been sent successfully, or not.
         * Return the appropriate message.
         */
        if (Mail::failures() != 0) {
            return "Email has been sent successfully.";
        }
        return "Oops! There was some error sending the email.";
    }
}
