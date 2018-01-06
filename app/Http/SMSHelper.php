<?php

namespace App\Http;

use Illuminate\Http\Client;
use Illuminate\Http\QueryString;
use Illuminate\Http\Client\Request;

class SMSHelper
{

    /**
     * Create a new controller instance.
     *
     * @return void
    */
    public function __construct() 
    {
        $this->middleware('auth');
    }

    public function SendSMS($message) {
        $sessionID = $this->GetSessionID();
        $response = $this->SendSMSOut($sendto, $message, $sessionID);

        // (new Notifications([
        //     'type' => 'emails',
        //     'read_at' => Carbon::today(),
        //     'data' => $message->getBody(),
        //     'owner_id' => $authid, //Auth::id()?? 0,
        //     'subject' => $message->getHeaders()->get('Subject')->getFieldBody(),
        //     'recipient' => !$message->getHeaders()->get('To') ? null : $message->getHeaders()->get('To')->getFieldBody(),
        // ]))->save();
    }

    private function GetSessionID() {
        $client = new Client;
        $request = new Request;

        $request->setRequestUrl('http://www.smslive247.com/http/index.aspx');
        $request->setRequestMethod('GET');
        $request->setQuery(new QueryString(array(
            'subacctpwd' => 'wurafleet1234',
            'subacct' => 'WURA',
            'owneremail' => 'triflyheaven@yahoo.com.au',
            'cmd' => 'login'
        )));

        $request->setHeaders(array(
            'content-type' => 'application/json'
        ));

        $client->enqueue($request)->send();
        $response = $client->getResponse();

        return $response->getBody();
    }

    private function SendSMSOut($sendto, $message, $sessionid) {
        $client = new Client;
        $request = new Request;

        $request->setRequestUrl('http://www.smslive247.com/http/index.aspx');
        $request->setRequestMethod('POST');
        $request->setQuery(new QueryString(array(
            'msgtype' => '0',
            'sendto' => $sendto,
            'sender' => 'wurafleet',
            'message' => $message,
            'sessionid' => $sessionid,
            'cmd' => 'sendmsg'
        )));

        $request->setHeaders(array(
            'content-type' => 'application/json'
        ));

        $client->enqueue($request)->send();
        $response = $client->getResponse();

        return $response->getBody();
    }
}
