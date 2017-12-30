<?php

namespace App\Mail\Registration;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Driver extends Mailable //implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $user;
    private $request;
    protected $tag = 'Drivers Email :: '; 
    const EMAIL_HEADER = 'Get Started with WURAfleet';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $request)
    {
        $this->user = $user;
        $this->request = $request->all();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        try {
            $twitter = env('twitter_url'); 
            $facebook = env('facebook_url'); 
            $linkedin = env('linkedin_url');
            $googleplus = env('googleplus_url');
            $email = trim($this->request['email']);
            $password = trim($this->request['password']);
            $manager = trim($this->user->firstname . ' ' . $this->user->lastname);
            $greeting = trim($this->request['firstname'] . ' ' . $this->request['middlename'] . ' ' . $this->request['lastname']);

            return $this->view('emails.registration.driver')
                        ->subject(self::EMAIL_HEADER)
                        ->with([
                            'email' => $email,
                            'manager' => $manager,
                            'password' => $password,                        
                            'greeting' => $greeting,
                            'twitter' => $twitter, 
                            'facebook' => $facebook, 
                            'linkedin' => $linkedin,
                            'googleplus' => $googleplus
                        ]);
        } catch (Exception $e) {
            Log::info($this->tag . json_encode($e));
        }
    }
}
