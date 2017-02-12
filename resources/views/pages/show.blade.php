@extends('layout')

@section('header_extra_meta_tags')
    <meta name="robots" content="index, follow">
    <meta name="description" content="{{ $page['seo_description'] or config('custom.default_seo_description') }}">
    <meta name="keywords" content="{{ $page['seo_tags'] or config('custom.default_seo_keywords') }}">

    <meta property="og:url"                content="{{Request::fullUrl()}}" />
    <meta property="og:type"               content="article" />
    <meta property="og:title"              content="{{$page['title'] or config('custom.default_og_title')}}" />
    <meta property="og:description"        content="{{$page['seo_description'] or config('custom.default_og_description')}}" />
@if (Gravatar::exists($page['author']['email']))
    <meta property="og:image"              content="{{ Gravatar::src($page['author']['email'], 128) }}" />
@endif
@endsection

@section('content_right')
    <div class="box content has-text-left">
        @if (Auth::check())
        <div class="is-2 is-pulled-right">
            <a href="{{action('PagesController@edit', ['id' => $page['id']])}}"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a>
        </div>
        @endif
        <h1 class="title is-2">{{$page['title']}}</h1>
        <h2 class="subtitle is-4">{{$page['subtitle']}}</h2>

        <div class="has-text-left ">
            {!! $page['content']  !!}
        </div>
    </div>
    @if ($page['author'])
    <div class="card is-fullwidth">
        <header class="card-header">
            <p class="card-header-title">
                About the author
            </p>
        </header>
        <div class="card-content">
            <article class="media">
                <div class="media-left">
                    <figure class="image is-64x64">
                        @if (Gravatar::exists($page['author']['email']))
                            <img src="{{ Gravatar::src($page['author']['email'], 128) }}" alt="Author image">
                        @else
                            <img src="http://placehold.it/128x128" alt="Image">
                        @endif
                    </figure>
                </div>
                <div class="media-content">
                    <div class="content">
                        <p>
                            <strong>{{$page['author']['name']}}</strong>
                            <br>
                            {{$page['author']['bio']}}
                        </p>
                    </div>
                </div>
            </article>
        </div>
        <footer class="card-footer">
            <a target="_blank" title="Share this page on Facebook" href="https://www.facebook.com/sharer/sharer.php?u={{Request::fullUrl()}}" class="card-footer-item">Share on Facebook</a>
            <a target="_blank" title="Share this page on Twitter" href="https://twitter.com/home?status={{Request::fullUrl()}}" class="card-footer-item">Share on Twitter</a>
            <a target="_blank" title="Share this page on Google Plus" href="https://plus.google.com/share?url={{Request::fullUrl()}}" class="card-footer-item">Share on G+</a>
        </footer>
        @endif
    </div>
@endsection