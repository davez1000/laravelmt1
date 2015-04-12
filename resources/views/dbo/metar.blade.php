@extends('app')

@section('content')

  @foreach ($metar as $m)
    <p>{!! $m !!}</p>
  @endforeach

@endsection
