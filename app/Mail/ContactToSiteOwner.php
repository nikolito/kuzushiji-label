<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ContactToSiteOwner extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id, $questions)
    {
        $this->id = $id;
        $this->questions = $questions;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        $user = User::where('id', $this->id)->first();
        $sender_name = $user->name;
        $sender_email = $user->email;
        $title = $sender_name. '様からのメールが届きました';
        $content = $this->questions;
        
        return $this->from($sender_email)
        ->to('webmaster@kuzushiji.work')
        ->subject($title)
        ->view('mail')
        ->with([
            'name' => $sender_name,
            'email' => $sender_email,
            'questions' => $content
        ]);
    }
}
