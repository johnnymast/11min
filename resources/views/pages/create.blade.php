@extends('layout')

@section('header_extra_scripts')
    {{--<script src="/js/ckeditor/ckeditor.js"></script>--}}
    <script src="https://cdn.ckeditor.com/4.6.1/standard-all/ckeditor.js"></script>
@endsection

@section('footer_extra_scripts')
    <script>
        CKEDITOR.replace('content');
    </script>
@endsection

@section('content_right')

    <div class="content has-text-right">
        <div class="is-2 is-pulled-right">
            @if (Auth::check())
                <a class="button is-outlined" href="{{action('PagesController@index')}}">
                    <span class="icon is-small"><i class="fa fa-chevron-left" aria-hidden="true"></i></span>
                    <span>Back to pages</span>
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


        {!! Form::open(array('route' => ['pages.store'], 'class' => 'form', 'novalidate')) !!}
        {{ csrf_field() }}

        {!! Form::label('title', 'Title', [
            'for' => 'title',
            'class' => 'label'
            ]) !!}
        <p class="control">
            {!! Form::text('title', null, ['required',
                                                     'id' => 'title',
                                                     'class'=>'input',
                                                     'placeholder'=> 'Page title']) !!}
        </p>

        {!! Form::label('active', 'Active', [
          'for' => 'active',
          'class' => 'label'
          ]) !!}
        <p class="control">
            {!! Form::checkbox('active', true, null,['id' => 'active']) !!}
        </p>

        {!! Form::label('subtitle', 'Subtitle', [
        'for' => 'subtitle',
        'class' => 'label'
        ]) !!}

        <p class="control">
            {!! Form::text('subtitle', null,
                   array('required',
                         'id' => 'subtitle',
                         'class'=>'input',
                         'placeholder'=>'Subtitle')) !!}
        </p>

        {!! Form::label('slug', 'Slug', [
           'for' => 'slug',
           'class' => 'label'
           ]) !!}
        <p class="control">
            {!! Form::text('slug', null,
                                               array('required',
                                                     'id' => 'slug',
                                                     'class'=>'input',
                                                     'placeholder'=> 'Page slug')) !!}
        </p>


        {!! Form::label('seo_tags', 'SEO Tags', [
           'for' => 'seo_tags',
           'class' => 'label'
           ]) !!}
        <p class="control">
            {!! Form::text('seo_tags', null,
                                               array(
                                                     'id' => 'seo_tags',
                                                     'class'=>'input',
                                                     'placeholder'=> 'SEO Tags')) !!}
        </p>

        {!! Form::label('seo_description', 'SEO Description', [
        'for' => 'seo_description',
         'class' => 'label'
        ]) !!}

        <p class="control">
            {!! Form::textarea('seo_description', null,
                array(
                      'class'=>'textarea',
                  )) !!}

        </p>

        {!! Form::label('content', 'Content', [
                'for' => 'content',
                 'class' => 'label'
                ]) !!}

        <p class="control">
            {!! Form::textarea('content', null,
                array('required',
                      'class'=>'textarea',
                      'Placeholder' => 'Page content here.'
                  )) !!}

        </p>
        <div class="control is-grouped">
            <p class="control">
                {!! Form::submit('Update',
                    ['class'=>'button is-primary']) !!}
            </p>
        </div>

        {!! Form::close() !!}
    </div>

@endsection