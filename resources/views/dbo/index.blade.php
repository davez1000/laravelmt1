@extends('master')

@section('content')

  @foreach ($result as $r)
    <p>{!! $r->raw !!}</p>
  @endforeach

@endsection
