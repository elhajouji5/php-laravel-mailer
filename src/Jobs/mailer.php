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
use Elhajouji5\phpLaravelMailer\Jobs\mailCore;

class mailer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;



    /**
    *@param List of mail receivers (subscribers) */
    private $list ;

    /**
    *@param Delay between sending each message in seconds */
    private $late;

    /** 
    *@param $tag (description) of this job */ 
    private $tag;

    /**
    *@param support agent sending manager*/
    private $support;

    /**
    *@param params of the job*/
    private $params;

    /**
     * Create a new job instance.
     * @return void
     */

    public function __construct( $params = null )
    {
        $this->params = $params;

        if($params){
            foreach($params as $key => $value)
                $this->setProperty($key, $value);
        }
    }

    /**
    *@return void, Set a proprty's value
    */

    public function setProperty($property, $value){

        if(property_exists($this, $property)){
            $this->$property = $value;
        }

    }


    /**
    *@return a proprty's value 
    */
    public function getProperty($property){

        if(property_exists($this, $property)){
            return $this->$property;
        }

    }

    // return void, Queue the email to the above list
    private function customizedSend(){

        $index = 0;
        foreach ($this->list as $recipient) {
            $params = [
                "support"    => $this->support,
                "seconds"    => $index * intval($this->late),
                "recipient"  => $recipient,
                "viewSource" => "subscriber",
                "viewData"   => [],
            ];
            dispatch( new mailCore($params) );
            $index++;
        }

    }    


    /**
    * @return void
    * sends email notification once the process started to the specified support agent
    * If no support agent specified, it'll be sent to the from email address
    */
    private function notifyFinished(){

        $params = [
            "support"    => $this->support,
            "seconds"    => count($this->list) * intval($this->late) + intval($this->late),
            "viewSource" => "support",
            "viewData"   => ["progress" => "finished", "tag" => $this->tag],
        ];
        dispatch( new mailCore($params) );

    }


    /**
    * @return void
    * sends email notification once the process finished to the specified support agent
    * If no support agent specified, it'll be sent to the from email address
    */
    private function notifyStart(){
        $params = [
            "support"    => $this->support,
            "seconds"    => 0,
            "viewSource" => "support",
            "viewData"   => [
                                "progress"      => "started",
                                "tag"           => $this->tag,
                                "elapsedTime"   => (count($this->list) * intval($this->late)),
                            ]
                   ];
        dispatch( new mailCore($params) );
    }



    /**
    * @return void
    * sends process notification via email to the specified support agent
    * If no support agent specified, it'll be sent to the from email address
    */

    private function notifyProcess($process){
        // 
    }


    /**
    * @return void 
    * set a tag to the job; so that eases the tracking from Horizon dashboard */

    public function tags(){
        // 
    }




    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->notifyStart();
        $this->customizedSend();
        $this->notifyFinished();

    }



}
