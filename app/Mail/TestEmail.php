<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    private User $user;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user; // Hatanın giderilmiş hali
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Thanks for Joining ' . config('app.name')) // 'build' metodu içerisinde subject belirleme
            ->view('emails.test-email') // 'build' metodu içerisinde view belirleme
            ->with(['user' => $this->user])
            ->attach(storage_path('app/public/profile/BagaWySv4518uz2Ibi68181BoSZJ61aC1pYAeFPE.jpg'), [
                'as' => 'profile_picture.jpg',
                'mime' => 'image/jpeg',
            ]); // Dosya ekleme
    }
}

