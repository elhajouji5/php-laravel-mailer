<?php

namespace Elhajouji5\phpLaravelMailer\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{

	/**
	*@param $fillable: contains the field that can be updated, inserted
	*/

    protected $fillable = [
    	"name", "email"
    ];


}
