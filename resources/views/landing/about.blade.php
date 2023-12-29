@extends('layouts.landing_app', ['title' => 'About'])
@section('content')
    @include('components.landing.header', ['title' => 'About'])
    @include('components.landing.service')
    @include('components.landing.about', ['company' => $company])
    @include('components.landing.team', ['mentors' => $mentors])
@endsection
