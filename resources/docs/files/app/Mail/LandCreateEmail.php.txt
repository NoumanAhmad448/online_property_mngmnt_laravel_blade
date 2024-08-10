<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LandCreateEmail extends Mailable {
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $name;

    public $email;

    public $land_create;

    public $subject;

    public function __construct($name, $email, $land_create, $subject) {
        $this->name = $name;
        $this->email = $email;
        $this->subject = $subject;

        $this->land_create = $land_create;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->from(fromMailer(config('mail.default')), $this->name)
            ->subject($this->subject)->markdown('emails.land_create');
    }
}
