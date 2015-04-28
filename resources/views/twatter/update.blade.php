@extends('master')

@section('content')
  <div>
    @if(Session::has('success'))
      <div class="alert-box success">
        <h2>{!! Session::get('success') !!}</h2>
      </div>
    @endif
    <div>
      {!! Form::open(array('action' => 'TwatterController@store', 'files' => TRUE)) !!}

      <div>{!! Form::label('status', 'Text:') !!}</div>
      <div>{!! Form::textarea('status') !!}</div>

      <div>{!! Form::label('status', 'Image (optional):') !!}</div>
      <div>{!! Form::file('image') !!}</div>
      <p class="errors">{!!$errors->first('image')!!}</p>

      @if(Session::has('error'))
        <p class="errors">{!! Session::get('error') !!}</p>
      @endif

      <div>{!! Form::submit('Send', array('class'=>'send-btn')) !!}</div>

      {!! Form::close() !!}
    </div>
  </div>
@endsection






