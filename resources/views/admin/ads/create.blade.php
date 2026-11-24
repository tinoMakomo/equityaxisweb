@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Create Ad</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Create Ad</li>
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
                                <h3 class="card-title pt-2">Create Ad</h3>
                            </div>
                            <div class="card-body p-0">
                                <div class="row justify-content-center">
                                    <div class="col-md-10">
                                        <form class="form-horizontal m-4" action="{{ route('admin_ads.store') }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="description" class="col-form-control-label">Ad Description
                                                    *</label>
                                                <textarea name="description" class="form-control" placeholder="Start typing here..."></textarea>
                                                @error('description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="link">Ad URL *</label>
                                                <input type="url" name="link" required class="form-control"
                                                    placeholder="Enter the ad link">
                                                @error('link')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="advert">Ad Image *</label>
                                                <div class="custom-file">
                                                    <input required type="file" class="custom-file-input" id="advert"
                                                        name="advert">
                                                    <label class="custom-file-label" for="advert">Choose
                                                        file</label>
                                                </div>
                                                @error('advert')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="preset">Ad Preset
                                                    *</label>
                                                <select class="form-control" name="preset" required>
                                                    <option value="">Select Ad Preset...</option>
                                                    @foreach (\App\Models\AdPreset::LIST as $preset)
                                                        <option value="{{ $preset }}">{{ $preset }}</option>
                                                    @endforeach
                                                </select>
                                                @error('preset')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-save">
                                                        </i>
                                                        Create Ad
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
    <script src="{{ asset('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
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

        $('#ads').select2();

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


        $(function() {
            bsCustomFileInput.init();
        });
    </script>
@endsection
