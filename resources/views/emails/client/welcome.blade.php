@component('mail::message')
# Welcome to {{config('app.name')}}

First of all welcome to {{ config('app.name') }}, This will be the first message you receive on your new email
account {{ $account->email }}. Your temporary email account will be valid until {{ $account->expires_at }}  after this you will be asked if you wish to extend this period.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
