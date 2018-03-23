<?php


Route::get("/test", function(){
	return ([
		"Code" => 200,
		"Message" => "It's working!"
	]);
});

Route::get("/send/{delay?}/{fromName?}/{fromAddr?}/{tag?}", "Elhajouji5\phpLaravelMailer\Controllers\mailController@trigger");

// send/5/Abdelilah/abdelilah@gmail.com/testing