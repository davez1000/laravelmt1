@extends('app')

@section('content')

  @foreach ($stuff as $s)
    <p>{!! $s !!}</p>
  @endforeach

@endsection
