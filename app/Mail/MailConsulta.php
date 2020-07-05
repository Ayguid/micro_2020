<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models440\Product;


class MailConsulta extends Mailable
{
    use Queueable, SerializesModels;

    public $toMail;
    public $fromMail;
    public $product;
    public $textArea;
    public $view;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($toMail, $fromMail, $product=null, $textArea=null, $view)
    {
        $this->view = $view;
        $this->toMail = $toMail;
        $this->fromMail = $fromMail;
        if ($product) {
          $this->product = $product;
        }
        if ($textArea) {
          $this->textArea = $textArea;
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      if ($this->view == 'user') {
        $v= 'mails.userMail';
      }
      if ($this->view == 'micro') {
        $v= 'mails.microMail';
      }
      return $this->from($this->fromMail, 'Mailtrap')
          ->subject('Mailtrap Confirmation')
          ->markdown($v)
          ->with([
              'toMail' => $this->toMail,
              'fromMail' => $this->fromMail,
              'product'=>$this->product,
              'text_area'=>$this->textArea,
              // 'link' => 'micro.com'
          ]);
    }
}
