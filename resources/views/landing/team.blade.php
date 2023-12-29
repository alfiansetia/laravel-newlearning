@extends('layouts.landing_app', ['title' => 'Team'])
@section('content')
    @include('components.landing.header', ['title' => 'Team'])
    @include('components.landing.team', ['mentors' => $mentors])
@endsection
