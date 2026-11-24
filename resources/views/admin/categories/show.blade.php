@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Category Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Categories</a></li>
                            <li class="breadcrumb-item active">Category Details</li>
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
                                <h3 class="card-title pt-2">{{ $category->title }}</h3>

                            </div>
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-md-9">
                                        <form class="form-horizontal m-4"
                                            action="{{ route('admin_categories.update', $category->id) }}" method="POST">
                                            @method('PUT')
                                            @csrf
                                            <div class="form-group">
                                                <label for="name">Name *</label>
                                                <input type="text" name="name" required class="form-control"
                                                    placeholder="Enter the category name" value="{{ $category->name }}">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="description" class="col-form-control-label">Category Description
                                                    *</label>
                                                <textarea name="description" class="form-control" placeholder="Start typing here...">{!! $category->description !!}</textarea>
                                                @error('description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="parent">Category Parent [Position]</label>
                                                <select id="parent" data-placeholder="Select category parent"
                                                    class="form-control" name="parent">
                                                    <option value="0">Select Category Parent...</option>
                                                    @foreach (\App\Models\Category::where('parent', '<', 1)->get() as $parent)
                                                        <option {{ $category->parent == $parent->id ? 'selected' : '' }}
                                                            value="{{ $parent->id }}">{{ $parent->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('parent')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="position">Position [Optional]</label>
                                                <input type="number" name="position" class="form-control"
                                                    placeholder="Enter the category position"
                                                    value="{{ $category->position }}">
                                                @error('position')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="display_in_navbar">Display In Navbar [Optional]</label>
                                                <select id="display_in_navbar" data-placeholder="Select category parent"
                                                    class="form-control" name="display_in_navbar">
                                                    <option value="">Select Option...</option>
                                                    <option {{ $category->display_in_navbar == 1 ? 'selected' : '' }}
                                                        value="1">Yes</option>
                                                    <option {{ $category->display_in_navbar == 0 ? 'selected' : '' }}
                                                        value="0">No</option>
                                                </select>
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
                                    <div class="col-md-3 order-1 order-md-2 border-left">
                                        <div class="m-3">
                                            <h3 class="text-primary"><i class="fas fa-info-circle"></i> Category Info</h3>
                                            <br>
                                            <div class="text-muted">
                                                <p class="text-sm">Last Updated
                                                    <b class="d-block">{{ $category->updated_at }}</b>
                                                </p>
                                                <p class="text-sm">Created At
                                                    <b class="d-block">{{ $category->created_at }}</b>
                                                </p>
                                            </div>
                                            <div class="mt-5 mb-3">
                                                <a class="btn btn-danger btn-sm"
                                                    onclick="confirmDeleteOperation('{{ route('admin_categories.destroy', $category->id) }}', 'category')"
                                                    href="#">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                    Delete
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


@section('styles-top')
    <link rel="stylesheet" href="{{ asset('admin/plugins/select2/css/select2.min.css') }}">
@endsection


@section('scripts')
    <script src="{{ asset('admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $('#categories').select2();
    </script>
@endsection
