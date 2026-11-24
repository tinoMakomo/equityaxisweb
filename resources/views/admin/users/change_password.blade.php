@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Change Password</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Prpfile</a></li>
                            <li class="breadcrumb-item active">Change Password</li>
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
                                <h3 class="card-title pt-2">Change Password</h3>

                            </div>
                            <div class="card-body p-0">
                                <div class="row justify-content-center">
                                    <div class="col-md-10">
                                        <form class="form-horizontal m-4" action="{{ route('admin.update_password') }}"
                                            method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="current_password">Current Password *</label>

                                                    <input type="password" name="current_password" class="form-control"
                                                        placeholder="Enter current password">
                                                    @error('current_password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="new_password">New Password *</label>
                                                    <input type="password" name="new_password" class="form-control"
                                                        placeholder="Enter new password">
                                                    @error('new_password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="new_password_confirmation">Confirm New Password *</label>
                                                    <input type="password" name="new_password_confirmation" class="form-control"
                                                        placeholder="Repeat new password">
                                                    @error('new_password_confirmation')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                            <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-save">
                                                        </i>
                                                        Save Password
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
