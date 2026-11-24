@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">User Preferences</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Preferences</li>
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
                                        <form class="form-horizontal m-4" action="{{ route('admin_preferences.update') }}"
                                            method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="dark_mode_set">Dark Mode <cite> - Set the interface design of the
                                                        dashboard to dark mode or light mode.</cite> </label>
                                                <select name="dark_mode_set" class="form-control custom-select">
                                                    <option value="1" {{ auth()->user()->preferences->dark_mode_set == 1 ? "selected" : "" }}>Dark Mode</option>
                                                    <option value="0" {{ auth()->user()->preferences->dark_mode_set == 0 ? "selected" : "" }}>Light Mode</option>
                                                </select>
                                                @error('dark_mode_set')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="flat_nav_bar_set">Flat Navbar <cite> - Set the navbar design to flat or default mode.</cite> </label>
                                                <select name="flat_nav_bar_set" class="form-control custom-select">
                                                    <option value="1" {{ auth()->user()->preferences->flat_nav_bar_set == 1 ? "selected" : "" }}>Flat Mode</option>
                                                    <option value="0" {{ auth()->user()->preferences->flat_nav_bar_set == 0 ? "selected" : "" }}>Default Mode</option>
                                                </select>
                                                @error('flat_nav_bar_set')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="fixed_header_set">Fixed Header <cite> - Set the top header of the dashboard to fixed on top or to scrollable.</cite> </label>
                                                <select name="fixed_header_set" class="form-control custom-select">
                                                    <option value="1" {{ auth()->user()->preferences->fixed_header_set == 1 ? "selected" : "" }}>Fixed Header</option>
                                                    <option value="0" {{ auth()->user()->preferences->fixed_header_set == 0 ? "selected" : "" }}>Scrollable Header</option>
                                                </select>
                                                @error('fixed_header_set')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Items Per Page <cite> - Set the number of items per page in a table.</cite> </label>
                                                <input type="number" name="items_per_page" class="form-control"
                                                    placeholder="Select the number of items to show in a table"
                                                    value="{{ auth()->user()->preferences->items_per_page }}">
                                                @error('fixed_header_set')
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
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection
