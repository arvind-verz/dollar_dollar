<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvestmentEnquiryMail extends Mailable
{
    use Queueable, SerializesModels;
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;
        //dd($data);
        return $this->subject('Investment Enquiry')->from($data['sender_email'], $data['sender_name'])->markdown('backend.emails.investmentEnquiry', compact("data"));
    }

}
