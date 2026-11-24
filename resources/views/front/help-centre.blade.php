@extends('layouts.public')

@section('title', 'Help Centre | Equity Axis')
@section('meta_description', 'Get help with Equity Axis subscriptions, research services, and account inquiries.')

@section('content')
    <div class="row mt-3">
        <div class="col-md-12">
            <h1>Help Centre</h1>
            <p>Need assistance with your Equity Axis subscription, research reports, or general inquiries? Our team is here to help.</p>
            <ul>
                <li>To subscribe to our newsletters and updates, visit our <a href="{{ route('subscribe') }}" class="text-primary">Subscribe page</a>.</li>
                <li>For editorial, advertising, or technical support questions, please use our <a href="{{ route('contact') }}" class="text-primary">Contact form</a>.</li>
                <li>Review our <a href="{{ route('privacy') }}" class="text-primary">Privacy Policy</a> and <a href="{{ route('terms') }}" class="text-primary">Terms &amp; Conditions</a>.</li>
            </ul>
        </div>
    </div>
@endsection
