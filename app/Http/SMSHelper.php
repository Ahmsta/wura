<?php

namespace App\Http;

use Auth;
use Carbon\Carbon;
use App\Models\Notifications;
use Illuminate\Support\Facades\Log;

class SMSHelper
{

  /**
   * Create a new controller instance.
   *
   * @return void
  */
  public function __construct() 
  {
      //$this->middleware('auth');
  }

  public function GetSessionID() {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://www.smslive247.com/http/index.aspx?cmd=login&owneremail=triflyheaven%40yahoo.com.au&subacct=WURA&subacctpwd=wurafleet1234",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json"
      ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    if ($err) {
      return "cURL Error #:" . $err;
    } else {
      return $response;
    }
  }

  public function SendSMS($sendto, $message, $msgType) {
    $sessionID = $this->GetSessionID();
    $response = explode(" ", $sessionID);

    if (strtolower($response[0]) == "ok:") {
      $SMSresponse = $this->SendSMSOut($sendto, $message, $response[1]);
    } else {
      Log::error(json_encode($sessionID));
    }
    
    $response = explode(" ", $SMSresponse);
    if (strtolower($response[0]) == "ok:") {
      (new Notifications([
          'type' => 'SMS',
          'data' => $message,
          'subject' => $msgType,
          'recipient' => $sendto,
          'read_at' => Carbon::today(),
          'owner_id' => Auth::id()?? 0,
      ]))->save();        
    } else {
      Log::error(json_encode($SMSresponse));
    }
  }

  public function SendSMSOut($sendto, $message, $sessionid) {

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://www.smslive247.com/http/index.aspx?cmd=sendmsg&sessionid=" . $sessionid . "&message=" . $message . "&sender=wurafleet&sendto=" . $sendto . "&msgtype=0",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_HTTPHEADER => array(
        "Content-Length: 0",
        "cache-control: no-cache",
        "content-type: application/json"
      ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    if ($err) {
      return "cURL Error #:" . $err;
    } else {
      return $response;
    }        
  }
}
