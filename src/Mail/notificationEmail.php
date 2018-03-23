<?php

namespace Elhajouji5\phpLaravelMailer\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class notificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    // Needed data (support, view to generate a message from and recipient) to generate a good targeted email
    protected $data;


    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct( $attributes )
    {
        $this->data         = $attributes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from( $this->data["support"]["from"]["address"] )
                    ->markdown('view::' . $this->data["view"] )
                    ->with( [ "viewData" => $this->data["viewData"] ] );
    }

}
