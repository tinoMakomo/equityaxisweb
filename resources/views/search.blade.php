@extends('layouts.public')
@section('content')
    <div class="row mt-3">
        <div class="col-12">
            <h2>'Putin'</h2>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-8">
            @include('includes.post-types.nine')
            @include('includes.post-types.nine')
            @include('includes.post-types.nine')
            @include('includes.post-types.nine')
            @include('includes.post-types.nine')
            @include('includes.post-types.nine')
        </div>
        <div class="col-md-4">
            <div class="thick-divider mb-1"></div>
                <h6>Recent Stories</h6>
            @include('includes.post-types.five')
            @include('includes.post-types.five')
            @include('includes.post-types.five')
            @include('includes.post-types.five')
            @include('includes.post-types.five')
            <a href="">
                <img src="{{ asset('images/ads/ad-600x600.png') }}" class="img ad">
            </a>
        </div>
    </div>
    @include('includes.divider')
    <div class="row mt-3">
        <div class="col-12">
            <h4>Top Stories</h4>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-3">
            @include('includes.post-types.three')
        </div>
        <div class="col-md-3">
            @include('includes.post-types.three')
        </div>
        <div class="col-md-3">
            @include('includes.post-types.three')
        </div>
        <div class="col-md-3">
            @include('includes.post-types.three')
        </div>
        <div class="col-md-3">
            @include('includes.post-types.three')
        </div>
        <div class="col-md-3">
            @include('includes.post-types.three')
        </div>
        <div class="col-md-3">
            @include('includes.post-types.three')
        </div>
        <div class="col-md-3">
            @include('includes.post-types.three')
        </div>
    </div>
@endsection
