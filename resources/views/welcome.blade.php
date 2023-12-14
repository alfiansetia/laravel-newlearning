@extends('layouts.frontend_app')


@section('content')
    @include('components.frontend.hero')

    {{-- @include('components.frontend.subcategories') --}}

    @include('components.frontend.categories')

    @include('components.frontend.banner')

    @include('components.frontend.latest')

    {{-- @include('components.frontend.blog') --}}
@endsection
