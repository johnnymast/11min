@component('mail::message')
# Introduction

You have got a new contact request from the {{ config('app.name') }} website.

<p>
<strong class="has-text-right">Name</strong>: {{$data['name']}}<br/>
<strong>Email</strong>: {{$data['email']}}<br/>
<strong>Date</strong>: {{$data['date']}}<br/>
<strong>Subject</strong>: {{$data['subject']}}<br/>
<br/>
{!! $data['message'] !!}
</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
