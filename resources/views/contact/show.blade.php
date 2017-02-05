@extends('layout')

@section('content_right')
    <div class="box content has-text-left">

        <h1 class="title is-2">Contact us</h1>
        <h2 class="subtitle is-4">
            Because your question deserves an answer.
        </h2>

        @if (count($errors) > 0)
            <div class="notification is-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(Session::has('message'))
            <div class="notification is-primary">
                {{Session::get('message')}}
            </div>
        @endif

        {!! Form::open(array('route' => 'contact_store', 'class' => 'form')) !!}
        {{ csrf_field() }}

        {!! Form::label('name', 'Your name', [
            'for' => 'name',
            'class' => 'label'
            ]) !!}
        <p class="control">
            {!! Form::text('name', null,
                                               array('required',
                                                     'id' => 'name',
                                                     'class'=>'input',
                                                     'placeholder'=> 'Your name')) !!}
        </p>

        {!! Form::label('email', 'Email', [
        'class' => 'label'
        ]) !!}

        <p class="control">
            {!! Form::email('email', null,
                   array('required',
                         'id' => 'email',
                         'class'=>'input',
                         'placeholder'=>'Your e-mail address')) !!}
        </p>

        {!! Form::label('subject', 'Subject', [
               'for' => 'subject',
               'class' => 'label'
               ]) !!}
        <p class="control">
            {!! Form::text('subject', null,
                                               array('required',
                                                     'id' => 'subject',
                                                     'class'=>'input',
                                                     'placeholder'=> 'Your subject')) !!}
        </p>


        {!! Form::label('message', 'Message', [
                 'class' => 'label'
                ]) !!}

        <p class="control">
            {!! Form::textarea('message', null,
                array('required',
                      'id' => 'message',
                      'class'=>'textarea',
                      'placeholder'=>'You can write your message here')) !!}

        </p>

        <div class="control is-grouped">
                {!! Recaptcha::render() !!}
        </div>
        <div class="control is-grouped">
            <p class="control">
                {!! Form::submit('Submit',
                    ['class'=>'button is-primary']) !!}
            </p>
        </div>

        {!! Form::close() !!}
    </div>
@endsection