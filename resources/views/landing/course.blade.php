@extends('layouts.landing_app')
@section('content')
    @include('components.landing.header', ['title' => 'Courses'])
    @include('components.landing.category', ['categories' => $categories])
    @include('components.landing.course', ['courses' => $courses])
    @include('components.landing.testi', ['comments' => $comments])
@endsection
