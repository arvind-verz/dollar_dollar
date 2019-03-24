<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProfileUpdated extends Mailable
{
    use Queueable, SerializesModels;
    private $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
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
        //
        $data = $this->data;
        //dd($data);
        return $this->subject('Profile Updated')->markdown('frontend.emails.profileUpdate', compact("data"));
    }
}
