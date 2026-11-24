@extends('layouts.public')

@section('title', 'Search Results | Equity Axis')

@section('content')
    <div class="row mt-3">
        <div class="col-12">
            <h2>Search results for '{{ $search }}'</h2>
        </div>
    </div>
    @include('includes.posts-collection')
@endsection
