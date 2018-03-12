@extends('layouts.home')

@section('header_extra_meta_tags')
    <meta name="robots" content="noindex, follow">
    <meta name="description" content="{{ config('custom.default_seo_description') }}">
    <meta name="keywords" content="{{ config('custom.default_seo_keywords') }}">

    <meta property="og:url" content="{{Request::fullUrl()}}"/>
    <meta property="og:type" content="{{config('custom.default_og_type')}}"/>
    <meta property="og:title" content="{{config('custom.default_og_title')}}"/>
    <meta property="og:description" content="{{config('custom.default_og_description')}}"/>
    <meta property="og:image" content="{{config('custom.default_og_image')}}"/>
@endsection

@section('content_left')
    <div class="has-text-left">

        <label class="label" for="temp_email">Your temporary email is</label>
        <div class="field has-addons">
            <div class="control">
                <input class="input" id="temp_email" type="text" value="{{ $account['email'] }}" readonly>
            </div>
            <div class="control">
                <a class="copy-to-clipboard button is-info" data-clipboard-target="#temp_email">
                    @lang('Copy to clipboard')
                </a>
            </div>
        </div>
        <countdown datetime="{{ date('Y-m-d H:i:s') }}" expires="{{ $account['expires_at'] }}"></countdown>
    </div>
@endsection

@section('content_right')
    <h2 class="title is-2 has-text-centered is-badge-medium is-primary" style="text-transform: uppercase">Your emails</h2>
    <mailbox/>
@endsection