<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\DemoMail;
class MailController extends Controller
{
    public function index()
    {
        $mailData = [
            'title' => 'mail from Quizintern',
            'body' => 'this is to test email usign smtp'
        ];

        Mail::to('suuraakoo777@gmail.com')->send(new DemoMail($mailData));
        dd('Email send successfully.');
    }
}
