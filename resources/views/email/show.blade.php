@extends('layout')



@section('content_right')
    <div class="is-one-quarter has-text-left">
        <a href="/" class="button is-outlined is-large"><i class="fa fa-inbox" aria-hidden="true"></i>&nbsp;Back to inbox</a>
    </div>
    <br />
    <div class="box is-three-quarters">
        <article class="media">
            <div class="media-content">
                <div class="content">
                    <p>
                        <strong class="has-text-right">From</strong>: {{$email['from']}}<br/>
                        <strong>To</strong>: {{$email['to']}}<br/>
                        <strong>Date</strong>: {{$email['when']}}<br/>
                        <strong>Subject</strong>: {{$email['subject']}}<br/>
                        <br/>
                        <br>
                        {!! $email['body'] !!}
                    </p>
                    <br/>
                </div>
            </div>
        </article>
    </div>
@endsection