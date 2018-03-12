@extends('layouts.home')

@section('content_right')

    <div class="content has-text-right">
        <div class="is-2 is-pulled-right">
            @if (Auth::check())
                <a class="btn button is-outlined" href="{{action('PagesController@create')}}">
                    <span class="icon"><i class="fa fa-plus-circle" aria-hidden="true"></i></span>
                    <span>Add page</span>
                    </a>
            @endif
        </div>
        <div class="is-clearfix"></div>
    </div>

    @if(Session::has('message'))
        <div class="notification is-primary">
            {{Session::get('message')}}
        </div>
    @endif

    @if (count($errors) > 0)
        <div class="notification is-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="box content has-text-left">
        <h1 class="title is-2">Pages</h1>

        <table class="table">
            <thead>
            <tr>
                <th>Title</th>
                <th>Subtitle</th>
                <th>Tools</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pages as $index => $page)
            <tr>
                <td><a target="_blank" href="/page/{{$page['slug']}}">{{ $page['title'] }}</a></td>
                <td>{{$page['subtitle']}}</td>
                <td>
                    {!! Form::open(['method' => 'DELETE', 'id' => 'deletePage'.$page['id'], 'route' => ['pages.destroy', $page['id']]]) !!}
                     {{ csrf_field() }}
                      <a class="button is-pulled-right" href="{{action('PagesController@destroy', ['id' => $page['id']])}}" onclick="return deletePage('deletePage{{$page['id']}}')">
                          <span class="icon is-small">
                            <i class="fa fa-trash-o fa-lg" aria-hidden="true"></i>
                          </span>
                      </a>
                    {!! Form::close() !!}
                    <a class="button is-pulled-right" href="{{action('PagesController@edit', ['id' => $page['id']])}}">
                        <span class="icon is-small"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>
                    </a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    </div>
    <script>
        function deletePage(form) {
            if (confirm('Are you sure?')) {
                document.getElementById(form).submit();
            }
            return false;
        }
    </script>
@endsection