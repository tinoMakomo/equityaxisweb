@extends('layouts.public')

@section('title', 'Contact Us | Equity Axis')
@section('meta_description', 'Have questions? Contact Equity Axis today for support, inquiries, or to learn more about our services.')

@section('content')
    <div class="row my-4">
        <div class="col-md-12 mb-5 contact-page">
            <h3>Contact Equity Axis</h3>
            <p>For more information about Equity Axis, get in touch with us now through any of the contact details below.
            </p>
            <hr>

            @if (Session::has('message'))
                <div class="col-md-12 my-4">
                    <div class="alert alert-success fade show py-4" role="alert">
                        {{ Session::get('message') }}
                    </div>
                </div>
            @endif

            <form action="{{ route('contact') }}" method="POST">
                @csrf
                <div class="row mb-5 mt-2 contact-info">
                    <div class="col-md-4">
                        <div class="d-flex">
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                            <label class="ms-3 form-check-label" for="news_updates">
                                <h3>Visit Us</h3>
                                32 Lawson Avenue, <br>
                                Milton Park, Harare <br>
                                Zimbabwe
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            <label class="ms-3 form-check-label" for="e_newspaper">
                                <h3>Email Us</h3>
                                admin@equityaxis.net <br>
                                reports@equityaxis.net
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            <label class="ms-3 form-check-label" for="email_services">
                                <h3>Call Us</h3>
                                +263 867 719 7791 <br>
                                +263 77 378 2392 <br>
                                +263 77 756 6204
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <h3>Leave a Message</h3>
                        <p>You can also leave us a message and your contact dei.</p>
                        <hr>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label mb-2">Full Name *</label>
                            <input required value="{{ old('full_name') }}" type="text" name="full_name"
                                class="form-control" placeholder="Your full name">
                            @error('full_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label mb-2">Email Address *</label>
                            <input value="{{ old('email') }}" required type="email" name="email" class="form-control" placeholder="Your email address">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="form-group">
                        <label for="" class="control-label mb-2">Message *</label>
                        <textarea name="message" rows="8" placeholder="Leave the message..." class="form-control">{{ old('message') }}</textarea>
                        @error('message')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <button class="a btn btn-primary fs-5 px-5 py-3 w-100"><b>Subscribe</b></button>
                </div>
            </form>
        </div>
    </div>
@endsection
