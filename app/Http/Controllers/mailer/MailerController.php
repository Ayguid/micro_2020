<?php

namespace App\Http\Controllers\mailer;
use App\Mail\MailConsulta;
use Illuminate\Support\Facades\Mail;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin;
use Illuminate\Support\Facades\Validator;


class MailerController extends Controller
{
  // protected $redirectTo = '/home';
  //
  // public function __construct()
  // {
  //     $this->middleware('auth');
  // }

  public function sendMail(Request $request)
  {
    $country = session('country');
    $to = $request->to;
    $from = $request->from;
    $product = $request->product;
    $text = $request->textArea;
    $defaultEmail = 'microSA@micro.com';

    $validator = Validator::make($request->all(), [
      'from' => 'required',
    ]);

    switch ($to) {
      case 'Comercial':
        $admins = Admin::where('country_id', $country->id)->where('contactable', '1')->where('job_title', $to)
        ->select('email')->get();
        break;
      case 'Ingenieria':
      $admins = Admin::where('country_id', '1')->where('job_title', $to)
      ->select('email')->get();
        break;
      default:
        break;
    }


    if (!$validator->fails()) {
      Mail::to($admins)
      ->send(new MailConsulta($admins, $from, $product, $text, 'micro'));//para micro

      Mail::to($from)
      ->send(new MailConsulta($from, $defaultEmail, $product, $text, 'user'));//para usuario

      return response()->json([
        'status' => 'ok',
        'message'=>\Lang::get('messages.email_sent')
      ]);
    }
    else {
      return response()->json([
        'status' => 'error',
        'errors' => $validator->messages()
      ]);
    }

  }



}
