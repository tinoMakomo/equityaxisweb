@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Create Category</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Create Category</li>
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
                                        <form class="form-horizontal m-4" action="{{ route('admin_categories.store') }}"
                                            method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="name">Name *</label>
                                                <input type="text" name="name" required class="form-control"
                                                    placeholder="Enter the category name">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="description" class="col-form-control-label">Category Description
                                                    *</label>
                                                <textarea name="description" class="form-control" placeholder="Start typing here..."></textarea>
                                                @error('description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="parent">Category Parent [Optional]</label>
                                                <select id="parent" data-placeholder="Select category parent"
                                                    class="form-control" name="parent">
                                                    <option value="0">Select Category Parent...</option>
                                                    @foreach (\App\Models\Category::where('parent', '<', 1)->get() as $parent)
                                                        <option value="{{ $parent->id }}">{{ $parent->name }}
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
                                                    placeholder="Enter the category position">
                                                @error('position')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="display_in_navbar">Display In Navbar [Optional]</label>
                                                <select id="display_in_navbar" data-placeholder="Select category parent"
                                                    class="form-control" name="display_in_navbar">
                                                    <option value="0">Select Option...</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-save">
                                                        </i>
                                                        Create Category
                                                    </button>
                                                </div>
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

@section('styles-top')
    <script src="{{ asset('admin/plugins/tinymce/tinymce.min.js') }}"></script>
    <link rel="stylesheet"
        href="{{ asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/select2/css/select2.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            $('#publish_at').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                },
                // format: 'YYYY-MM-DD HH:mm:ss',
                // defaultDate: moment().format(),
            });
        });

        $('#categories').select2();

        $('#tags').select2({
            'tags': true
        })


        tinymce.init({
            selector: 'textarea#rich-text-editor',
            height: 500,
            menubar: false,

            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    </script>
@endsection
