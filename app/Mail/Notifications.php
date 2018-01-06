<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;

class Notifications extends Mailable //implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $title;
    private $greeting;
    private $drivermsg;
    protected $tag = 'Notifications Email :: '; 
    const EMAIL_HEADER = 'WURAfleet Notification ';

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 120;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $drivermsg, $greeting)
    {
        $this->title = $title;
        $this->greeting = $greeting;
        $this->drivermsg = $drivermsg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        try {
            $title = $this->title;
            $greeting = $this->greeting;
            $drivermsg = $this->drivermsg;
            $twitter = env('twitter_url'); 
            $facebook = env('facebook_url'); 
            $linkedin = env('linkedin_url');
            $googleplus = env('googleplus_url');

            return $this->view('emails.notifications')
                        ->subject($title)
                        ->with([
                            'title' => $title,
                            'drivermsg' => $drivermsg,                        
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
