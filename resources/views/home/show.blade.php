@extends('layout')

@section('header_extra_meta_tags')
    <meta name="robots" content="noindex, follow">
    <meta name="description" content="{{ config('custom.default_seo_description') }}">
    <meta name="keywords" content="{{ config('custom.default_seo_keywords') }}">

    <meta property="og:url"                content="{{Request::fullUrl()}}" />
    <meta property="og:type"               content="{{config('custom.default_og_type')}}" />
    <meta property="og:title"              content="{{config('custom.default_og_title')}}" />
    <meta property="og:description"        content="{{config('custom.default_og_description')}}" />
    <meta property="og:image"              content="{{config('custom.default_og_image')}}" />
@endsection

@section('content_left')
    <div class="has-text-left">
        <label class="label">Your temporary email is</label>
        <p class="control has-addons">
            <input class="input is-90-percent" id="temp_email" type="text"
                   value="{{ $account['email'] }}" readonly/>
            <a class="copy-to-clipboard button is-info" data-clipboard-target="#temp_email">Copy to
                clipboard</a>
        </p>
        <countdown now="{{ date('Y-m-d H:i:s') }}" expires="{{ $account['expires_at'] }}"></countdown>
    </div>
@endsection

@section('content_right')
    <h2 class="title is-2 has-text-centered is-large" style="text-transform: uppercase">Your emails</h2>
    <mailbox  />
@endsection