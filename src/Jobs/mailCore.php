<?php

namespace Elhajouji5\phpLaravelMailer\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use Carbon\Carbon;

use Elhajouji5\phpLaravelMailer\Mail\notificationEmail;

class mailCore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;



    /**
    *@param object: mail receiver */
    private $recipient ;

    /**
    *@param integer: Delay between sending each message in $seconds */
    private $seconds;

    /**
    *@param array: support agent (campaign manager)*/
    private $support;

    /**
    *@param string: mail html content */
    private $viewSource;

    /**
    *@param array: mail details that will be passed to the message body */
    private $viewData;


    public function __construct( $params )
    {
        if($params){
            foreach($params as $key => $value)
                $this->setProperty($key, $value);
        }
        $this->recipient = $this->recipient ??
                           $this->support["notify"]["email"] ??
                           $this->support["from"]["address"];

        $this->generateViewData();
    }


    public function handle()
    {
        $htmlAttributes = ["support" => $this->support, "view" => $this->viewSource,
                            "recipient" => $this->recipient, "viewData" => $this->viewData];
        $when = Carbon::now()->addSeconds( $this->seconds );
        $mail = (new notificationEmail( $htmlAttributes ));
        Mail::to($this->recipient)->later($when, $mail );

    }

    public function setProperty($property, $value){

        if(property_exists($this, $property)){
            $this->$property = $value;
        }

    }

    public function tags(){
        return [$this->recipient];
        // return ["$this->recipient->name <$this->recipient->email>"];
    }

    // Detect the targeted person that the campaign will be sent to,
    // And generate the appropriate data to send to the email view
    private function generateViewData(){

        if($this->viewSource == "progress"){
            if($this->viewData["progress"] == "started"){
                // to admin: Started
            }elseif($this->viewData["progress"] == "finished"){
                // to admin: finished
            }
        }elseif($this->viewSource == "feature"){
            // To recipient
        }

    }


}
