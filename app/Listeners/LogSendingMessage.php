<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Models\Notifications;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogSendingMessage
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MessageSending  $event
     * @return void
     */
    public function handle(MessageSending $event)
    {   
        $message = $event->message;
        $authid = explode("@", $message->getHeaders()->get('Bcc')->getFieldBody())[0];
        header_remove("Bcc"); 
        
        (new Notifications([
            'type' => 'emails',
            'read_at' => Carbon::today(),
            'data' => $message->getBody(),
            'owner_id' => $authid, //Auth::id()?? 0,
            'subject' => $message->getHeaders()->get('Subject')->getFieldBody(),
            'recipient' => !$message->getHeaders()->get('To') ? null : $message->getHeaders()->get('To')->getFieldBody(),
        ]))->save();
    }
}
