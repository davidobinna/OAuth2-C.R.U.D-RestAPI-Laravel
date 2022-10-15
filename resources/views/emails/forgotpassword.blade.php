@component('mail::message')
# Introduction

{{ $usersubject }}

Hello David, do you want to reset your password for this email ?$_COOKIE
{{ $useremail }}  please reset now 


reset password link here: {{ $link }}
@component('mail::button', ['url' => " {{ $link }} "])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
