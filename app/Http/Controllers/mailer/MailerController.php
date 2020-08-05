<?php

namespace App\Http\Controllers\mailer;
use App\Mail\MailConsulta;
use Illuminate\Support\Facades\Mail;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use App\Admin;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Models440\User_Title;
use DB;
// use App;

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
    $title=0;

    switch ($to) {//titles
      case 'Ingenieria':
        $title = 1;
        break;
      case 'Comercial':
        $title = 2;
        break;
      default:
        break;
    }

    $titles = User_Title::where('country_id', "=", $country->id)->where('title_id', '=', $title)->pluck('user_id');
    $users = DB::table('users')->whereIn('id', $titles)->get();

    $validator = Validator::make($request->all(), [
      'from' => 'required',
    ]);

    if (!$validator->fails()) {
      Mail::to($users)
      ->send(new MailConsulta($users, $from, $product, $text, 'micro'));//para micro

      Mail::to($from)
      ->send(new MailConsulta($from, $defaultEmail, $product, $text, 'user'));//para usuario


      // $request->locale
      return response()->json([
        'status' => $request,
        'message'=> \Lang::get('messages.email_sent')
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
