@extends('master')

@section('content')

    <div class="container">

        <h2 class="form-signin-heading">Send This</h2>

        @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif

        @if(Session::has('success'))
            <div class="alert-box success">
                <h2>{!! Session::get('success') !!}</h2>
            </div>
        @endif

        <div>
            {!! Form::open(array('action' => 'TwatterController@store', 'files' => TRUE)) !!}

            <div>{!! Form::label('status', 'Status Text:') !!}</div>
            <div>{!! Form::textarea('status', NULL, array('class' => 'input-block-level')) !!}</div>
            @if($errors->get('status'))
                <p class="errors">
                    @foreach($errors->get('status') as $e)
                        {!! $e !!}
                    @endforeach
                </p>
            @endif
            
            @for($i = 0; $i < 4; $i++)
                <div>{!! Form::label('status', 'Image ' . ($i + 1) . ':') !!}</div>
                <div>{!! Form::file('image' . $i, NULL, array('class' => 'input-block-level')) !!}</div>
                @if($errors->get('image' . $i))
                    <p class="errors">
                        @foreach($errors->get('image' . $i) as $e)
                            {!! $e !!}
                        @endforeach
                    </p>
                @endif
            @endfor

            <div>{!! Form::submit('Post', array('class'=>'btn btn-large btn-primary')) !!}</div>

            {!! Form::close() !!}
        </div>

    </div>

@endsection
