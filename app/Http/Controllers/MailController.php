<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    //

    public static function sendPasswordForgetMailTo(string $receiver,string $password = "")
    {
        Mail::send(['text'=>'mail'], ['receiver'=>$receiver, 'password'=>$password ], function($message) use ($receiver,$password) {
           $message->to($receiver, 'Tutorials Point')->subject ('Vous aviez lance la procedure de reinitialisation de mot de passe \n Utilisez le code: '.$password.' pour vous connecter a vote compte');
           $message->from('todolist229@gmail.com','TodoList');
        });

    }
}
