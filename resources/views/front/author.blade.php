@extends('layouts.public')

@section('title', $user->name . ' | Equity Axis')
@section('meta_description', $user->bio)

@section('content')
    <div class="row mt-3 ">
        <div class="col-12">
            <h2>{{ $user->name }}</h2>
            <h6 class="mt-2">{{ $user->bio }}</h6>
            <div class="d-block my-4"></div>
            <div class="d-flex">
                <a target="_blank" href="mailto:{{ $user->email }}?cc=admin@equityaxis.net" class="user-icon me-5">
                    <span class="badge rounded-circle">
                        <i class="fa fa-envelope"></i>
                    </span>
                    <strong>Email {{ $user->getFirstName() }}</strong>
                </a>
                <a target="_blank" href="https://twitter.com/EquityAxis"
                    class="user-icon twitter">
                    <span class="badge rounded-circle">
                        <i class="fab fa-twitter-square"></i>
                    </span>
                    <strong>Follow On Twitter</strong>
                </a>
            </div>
            <hr>
        </div>
    </div>

    @include('includes.posts-collection')
@endsection
