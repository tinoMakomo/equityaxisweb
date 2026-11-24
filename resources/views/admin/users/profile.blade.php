@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">User Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.includes.messages')
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title pt-2">Profile</h3>
                            </div>
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-md-8">
                                        <form class="form-horizontal m-4" action="{{ route('admin_profile.update') }}"
                                            method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="name">Name *</label>
                                                <input type="name" name="name" class="form-control"
                                                    placeholder="e.g Rufaro Sithole" value="{{ auth()->user()->name }}">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email *</label>
                                                <input type="email" name="email" class="form-control"
                                                    placeholder="e.g rufaro@gmail.com"
                                                    value="{{ auth()->user()->email }}">
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="bio">Bio</label>
                                                <textarea name="bio" rows="3" class="form-control"
                                                    placeholder="e.g A software developer based in Harare Zimbabwe.">{{ auth()->user()->bio }}</textarea>
                                                @error('bio')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="twitter">Twitter</label>
                                                <input type="text" name="twitter" class="form-control"
                                                    placeholder="e.g https://twitter.com/emarss04"
                                                    value="{{ auth()->user()->twitter }}">
                                                @error('twitter')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="linkedin">LinkedIn</label>
                                                <input type="text" name="linkedin" class="form-control"
                                                    placeholder="e.g https://www.linkedin.com/in/rufaro-sithole"
                                                    value="{{ auth()->user()->linkedin }}">
                                                @error('linkedin')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="phone">Phone</label>
                                                <input type="text" name="phone" class="form-control"
                                                    placeholder="e.g +263774671339" value="{{ auth()->user()->phone }}">
                                                @error('phone')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save">
                                                    </i>
                                                    Save Changes
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-4 order-1 order-md-2 border-left">
                                        <div class="m-3">
                                            <h3 class="text-primary"><i class="fas fa-info-circle"></i> User Info</h3>
                                            <br>
                                            <div class="text-muted">
                                                <p class="text-sm">Account Type
                                                    <b class="d-block">{{ auth()->user()->userType->name }}</b>
                                                </p>
                                                <hr>
                                                <p class="text-sm">Last Updated
                                                    <b class="d-block">{{ auth()->user()->updated_at }}</b>
                                                </p>
                                                <p class="text-sm">Created At
                                                    <b class="d-block">{{ auth()->user()->created_at }}</b>
                                                </p>

                                            </div>
                                            <div class="mt-5 mb-3">
                                                <a class="btn btn-primary"
                                                    href="{{ route('admin.change_password') }}">
                                                    <i class="fas fa-edit">
                                                    </i>
                                                    Change Password
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection
