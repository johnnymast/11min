<nav class="navbar is-white">
  <div class="navbar-brand">
    <a class="navbar-item" href="https://bulma.io">
      
        {{--<img src="https://bulma.io/images/bulma-logo.png" alt="Bulma: a modern CSS framework based on Flexbox" width="112" height="28">--}}
      
    </a>
    <div class="navbar-burger burger" data-target="navMenuColorwhite-example">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>

  <div id="navMenuColorwhite-example" class="navbar-menu">
    <div class="navbar-start"></div>

    <div class="navbar-end">
        <a class="navbar-item @if (Route::currentRouteName() == 'home') is-active @endif"  href="{{ route('home') }}">
            Home
        </a>
        @foreach ($pages as $page)
            <a href="/page/{{$page['slug']}}"
               class="navbar-item @if ($slug == 'page/'.$page['slug']) is-active @endif">
                {{$page['title']}}
            </a>
        @endforeach
        <a href="{{ route('contact.index') }}"
           class="navbar-item @if (Route::currentRouteName() == 'contact.index') is-active @endif">
            Contact
        </a>
    </div>
  </div>
</nav>
