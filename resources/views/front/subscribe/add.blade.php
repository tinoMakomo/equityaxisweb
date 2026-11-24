@extends('layouts.public')

@section('title', 'Newsletter | Equity Axis')
@section('meta_description', 'Equity Axis Subscription Services')

@section('content')
    <div class="row my-4">
        <div class="col-md-12 mb-5">
            <h3>Equity Axis Subscription Services</h3>
            <p>Please, select the service(s) for which you want to subscribe, fill in your details below, and hit the
                Subscribe button to complete.</p>
            <hr>

            @if (Session::has('message'))
                <div class="col-md-12 my-4">
                    <div class="alert alert-success fade show py-4" role="alert">
                        {{ Session::get('message') }}
                    </div>
                </div>
            @endif

            <form action="{{ route('subscribe.add') }}" method="POST">
                @csrf
                <div class="row mb-5 mt-2">
                    <div class="col-md-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input mt-2" name="news_updates" type="checkbox" role="switch"
                                id="news_updates"
                                {{ old('news_updates') == 'on' || old('news_updates') == null ? 'checked' : '' }}>
                            <label class="ms-3 form-check-label" for="news_updates">
                                <h3>News Updates</h3>
                                Subscribe to receive our news one the go to your email.
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input mt-2" name="e_newspaper" type="checkbox" role="switch"
                                id="e_newspaper"
                                {{ old('e_newspaper') == 'on' || old('e_newspaper') == null ? 'checked' : '' }}>
                            <label class="ms-3 form-check-label" for="e_newspaper">
                                <h3>E-Newspaper</h3>
                                Subscribe to receive THE AXiS, a weekly ne-ewspaper published every Friday.
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input mt-2" name="email_services" type="checkbox" role="switch"
                                id="email_services"
                                {{ old('email_services') == 'on' ? 'checked' : '' }}>
                            <label class="ms-3 form-check-label" for="email_services">
                                <h3>Email Services</h3>
                                Subscribe to receive our financial, economic intelligence and analysis to your email.
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label mb-2">Email Address *</label>
                            <input value="{{ old('email') ?? $email }}" required type="email" name="email"
                                class="form-control">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label mb-2">Full Name *</label>
                            <input required value="{{ old('full_name') }}" type="text" name="full_name"
                                class="form-control">
                            @error('full_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label mb-2">Mobile Number *</label>
                            <input required value="{{ old('mobile_number') }}" type="text" name="mobile_number"
                                class="form-control">
                            @error('mobile_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label mb-2">Company Name</label>
                            <input value="{{ old('company') }}" type="text" name="company" class="form-control">
                            @error('company')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="">
                    <button class="a btn btn-primary fs-5 px-5 py-3 w-100"><b>Subscribe</b></button>
                </div>
            </form>
        </div>
    </div>
@endsection
