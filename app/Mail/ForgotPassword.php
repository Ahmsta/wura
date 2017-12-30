<?php

namespace App\Mail;

use App\Models\PasswordReset;
use App\Models\User;
use App\Namespaces;
use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgotPassword extends Mailable //implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $user;
    private $resetData;

    const RESET_PASSWORD_HEADER = 'Reset you Feedfast Password';

    /**
     * Create a new message instance.
     *
     * @param $user
     * @param $resetData
     */
    public function __construct(User $user, PasswordReset $resetData)
    {
        $this->user = $user;
        $this->resetData = $resetData;
    }

    /**
     * Build the password reset email.
     *
     * @return $this
     */
    public function build()
    {
        $header = trim($this->user->firstname . ' ' . $this->user->lastname);
        $header = $header ?: $this->user->email;
        $resetUrl = self::getResetUrl($this->resetData->email, $this->resetData->token);

        Log::info(Namespaces::AUTHENTICATION . ':: Sending email to '. $this->resetData->email . ' to password reset');

        return $this->view('emails.forgot_password')
            ->subject(self::RESET_PASSWORD_HEADER)
            ->with([
                'header' => $header,
                'resetUrl' => $resetUrl,
            ]);
    }

    /**
     * Build the reset password url to be included in the email
     * @param $email
     * @param $token
     * @return string
     */
    private static function getResetUrl($email, $token)
    {
        $url = env('FE_PASSWORD_RESET_URL');
        return ($url . "?email={$email}&token={$token}");
    }
}