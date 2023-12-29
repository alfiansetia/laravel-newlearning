@extends('layouts.landing_app')
@section('content')
    @include('components.landing.header', ['title' => 'Team'])
    @include('components.landing.team', ['mentors' => $mentors])
@endsection
