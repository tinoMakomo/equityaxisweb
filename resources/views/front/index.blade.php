@extends('layouts.public')
@section('content')
    @include('includes.home.hero')
    @include('includes.divider')
    @include('includes.home.top-stories')
    @include('includes.divider')
    @include('includes.home.trending')
    @include('includes.divider')
    @include('includes.home.more-stories')
    @include('includes.divider')

    {{-- <a href="{{ Helper::getAdUrl('footer') }}">
        <img src="{{ Helper::getAd('footer') }}" class="img ad my-3" style="width: 100%">
    </a> --}}
@endsection
