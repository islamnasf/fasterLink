@component('mail::message')

<p><b>'Your OTP is: </b> {{ $otp }}</p> 
<p>It will expire in 10 minutes. Please use it soon.</p> 

@endcomponent