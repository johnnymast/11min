@extends('layout')

@section('content_left')
    <div class="has-text-left">
        <label class="label">Your temporary email is</label>
        <p class="control has-addons">
            <input class="input is-90-percent" id="temp_email" type="text"
                   value="{{ $account['email'] }}" readonly/>
            <a class="copy-to-clipboard button is-info" data-clipboard-target="#temp_email">Copy to
                clipboard</a>
        </p>
        <countdown date="{{ $account['expires_at'] }}"></countdown>
    </div>
@endsection

@section('content_right')
    <h2 class="title is-2 has-text-centered is-large" style="text-transform: uppercase">Your emails</h2>
    <mailbox/>
@endsection