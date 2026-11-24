@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Create User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Create User</li>
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
                            <div class="card-body p-0">
                                <div class="row justify-content-center">
                                    <div class="col-md-10">
                                        <form class="form-horizontal m-4" action="{{ route('admin_users.store') }}"
                                            method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="name">Name *</label>
                                                <input type="text" name="name" required class="form-control"
                                                    placeholder="e.g Rufaro Sithole">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email *</label>
                                                <input type="email" name="email" required class="form-control"
                                                    placeholder="e.g rufaro@gmail.com">
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="user_type_id">Account Type
                                                    *</label>
                                                <select class="form-control" name="user_type_id" required>
                                                    <option value="">Select Account Type...</option>
                                                    @foreach (\App\Models\UserType::all() as $type)
                                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('user_type_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password *</label>
                                                    <input type="password" name="password" class="form-control"
                                                        placeholder="Enter password">
                                                    @error('password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="password_confirmation">Confirm Password *</label>
                                                    <input type="password" name="password_confirmation" class="form-control"
                                                        placeholder="Repeat password">
                                                    @error('password_confirmation')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="bio">Bio</label>
                                                <textarea name="bio" rows="3" class="form-control"
                                                    placeholder="e.g A software developer based in Harare Zimbabwe."></textarea>
                                                @error('bio')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="twitter">Twitter</label>
                                                <input type="text" name="twitter" class="form-control"
                                                    placeholder="e.g https://twitter.com/emarss04">
                                                @error('twitter')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="linkedin">LinkedIn</label>
                                                <input type="text" name="linkedin" class="form-control"
                                                    placeholder="e.g https://www.linkedin.com/in/rufaro-sithole">
                                                @error('linkedin')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="phone">Phone</label>
                                                <input type="text" name="phone" class="form-control"
                                                    placeholder="e.g +263774671339">
                                                @error('phone')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save">
                                                    </i>
                                                    Create User
                                                </button>
                                            </div>
                                        </form>
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
