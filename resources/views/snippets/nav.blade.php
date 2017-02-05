<nav class="nav has-shadow" id="top">
    <div class="container">
        <div class="nav-left">
            <a class="nav-item" href="/">
                <img src="/images/bulma.png" alt="Description">
            </a>
        </div>
        <span class="nav-toggle">
            <span></span>
            <span></span>
            <span></span>
      </span>
        <div class="nav-right nav-menu">
            <a href="{{ route('home') }}"
               class="nav-item is-tab @if (Route::currentRouteName() == 'home') is-active @endif">
                Home
            </a>
            @foreach ($pages as $page)
                <a href="/page/{{$page['slug']}}"
                   class="nav-item is-tab @if ($slug == 'page/'.$page['slug']) is-active @endif">
                    {{$page['title']}}
                </a>
            @endforeach
            <a href="{{ route('contact') }}"
               class="nav-item is-tab @if (Route::currentRouteName() == 'contact') is-active @endif">
                Contact
            </a>
        </div>
    </div>
</nav>
