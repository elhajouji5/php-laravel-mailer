@component('mail::message')
# Great news campaign admin!

@if(isset($viewData["progress"]))
	@if($viewData["progress"] == "started")
		The campaign {{ strtoupper($viewData['tag']) }} is scheduled to be sent.
		The estimated time that this process can take is approximately: {{ $viewData['elapsedTime'] }} seconds
	@endif
@endif

@if(isset($viewData["progress"]))
	@if($viewData["progress"] == "finished")
		The campaign {{ strtoupper($viewData['tag']) }} has been sent successfully.
		Please check the dashboard to see if there is any undelivered email,
		in order to resend it again
	@endif
@endif


Cheers,<br>
{{ config('app.name') }}
@endcomponent

