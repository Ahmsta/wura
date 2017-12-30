<?php

namespace App\Jobs;

use App\Models\User;
use App\Mail\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
// use App\Mail\Registration\Driver;
use App\Mail\Registration\Merchants;
use Illuminate\Queue\SerializesModels;
use App\Mail\Registration\CorporateUser;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\Registration\IndividualUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $details;
    protected $email;

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
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, array $details) // User $user,
    {
        $this->email = $email;
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $mailer->send('emails.notifications', ['user' => $this->user], function ($m) {
        //     //
        // });
        switch (strtolower($this->details['Action'])) {

            case 'notifications':
                Mail::to($this->email)->send(new Notifications($this->details['Title'], $this->details['Message'], $this->details['Greeting']));
                break;

            case "merchant":
                Mail::to($this->email)->send(new Merchants($this->details['User']));
                break;

            case "corporation":
                Mail::to($this->email)->send(new CorporateUser($this->details['User']));
                break;

            case "individual":
                Mail::to($this->email)->send(new IndividualUser($this->details['User']));
                break;
        }
    }
}
