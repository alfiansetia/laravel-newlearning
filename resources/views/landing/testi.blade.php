@extends('layouts.landing_app', ['title' => 'Testi'])
@section('content')
    @include('components.landing.header', ['title' => 'Testi'])
    @include('components.landing.testi', ['comments' => $comments])
@endsection
