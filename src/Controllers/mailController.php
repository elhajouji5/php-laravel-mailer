<?php

namespace Elhajouji5\phpLaravelMailer\Controllers;

use App\Http\Controllers\Controller;
use Elhajouji5\phpLaravelMailer\Jobs\mailer;
use Elhajouji5\phpLaravelMailer\Models\Subscriber;

class mailController extends Controller
{

    /* $params that job mailer expects   */ 
    protected $params;


    public function trigger($delay = null, $fromName = null, $fromAddr = null, $tag = null){

        $this->params['list']      = Subscriber::all();
        $this->params['late']      = $delay ?? 0; // OPTIONAL dely between sending messages in seconds
        $this->params['tag']       = ($tag) ?? "Unspecified"; // OPTIONAL tag (description) of this job
        $this->params['support']["from"] = [ // Optional from; If not specified the global from (in config\mail.php) will be used
                                                'address' => $fromAddr ?? "sender@univers.com",
                                                'name' => $fromName ?? "Example",
                                            ];
        $this->params['support']["notify"] = ["email" => "reply-me@support.com"];
        $job = (new mailer($this->params));

        dispatch($job);

        return [
            "code"    => 200,
            "message" => "Messages queued to be sent in a customized delay",
        ];

    }




}
