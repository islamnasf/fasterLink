<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreateStoreMail extends Mailable
{
    use Queueable, SerializesModels;

    public $store;
    /**
     * Create a new message instance.
     */
    public function __construct($store)
    {
        $this->store = $store;
    }

    public function build()
    {
        return $this->markdown('emails.create_store')
            ->subject('There is a new store, please check its details');
    }
}
