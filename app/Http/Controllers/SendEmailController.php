<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class SendEmailController extends Controller
{
  public function index()
  {
    Mail::to("qmkahlout@gmail.com")->send(new SendMail());

    return "Great! Seccessfully send in your mail";
  }
}
