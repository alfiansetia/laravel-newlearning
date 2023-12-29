@extends('layouts.landing_app')
@section('content')
    @include('components.landing.header', ['title' => 'About'])
    @include('components.landing.service')
    @include('components.landing.about')
    @include('components.landing.team', ['mentors' => $mentors])
@endsection
