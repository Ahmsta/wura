<?php

namespace App\Mail\Registration;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CorporateUser extends Mailable //implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $user;
    const EMAIL_HEADER = 'Get Started with WURAfleet';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $twitter = env('twitter_url'); 
        $facebook = env('facebook_url'); 
        $linkedin = env('linkedin_url');
        $googleplus = env('googleplus_url');
        $walletUrl = env('APP_URL') . '/wallet';        
        $driversUrl = env('APP_URL') . '/drivers';

        $greeting = trim($this->user->firstname . ' ' . $this->user->lastname);
        
        return $this->view('emails.registration.corporateuser')
                    ->subject(self::EMAIL_HEADER)
                    ->with([
                        'greeting' => $greeting,
                        'walletUrl' => $walletUrl,                        
                        'driversUrl' => $driversUrl,
                        'twitter' => $twitter, 
                        'facebook' => $facebook, 
                        'linkedin' => $linkedin,
                        'googleplus' => $googleplus
                    ]);
    }
}
