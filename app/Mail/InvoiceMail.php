<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;
    public $invoice,$invoiceitem,$toAddress,$fromAddress,$pdf,$email;

    public function __construct($invoice,$invoiceitem,$toAddress,$fromAddress,$pdf,$email)
    {
        $this->invoiceitem = $invoiceitem;
        $this->invoice = $invoice;
        $this->toAddress = $toAddress;
        $this->fromAddress = $fromAddress;
        $this->pdf = $pdf;
        $this->email =  $email;
//         dd($this->pdf);
    }

    public function build()
    {
        // dd($this->invoice[0]['prefix'].$this->invoice[0]['invoice_number']);
        return $this->markdown('emails.mail')->subject($this->email[0]['subject'].' ('.$this->invoice[0]['prefix'].$this->invoice[0]['invoice_number'].')')
                    ;
    }
}
