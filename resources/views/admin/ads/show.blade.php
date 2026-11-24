@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Ad Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Ads</a></li>
                            <li class="breadcrumb-item active">Ad Details</li>
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
                                <h3 class="card-title pt-2">{{ $ad->name }}</h3>

                            </div>
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-md-9">
                                        <form class="form-horizontal m-4"
                                            action="{{ route('admin_ads.update', $ad->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @method('PUT')
                                            @csrf
                                            <div class="form-group">
                                                <label for="description" class="col-form-control-label">Ad Description
                                                    *</label>
                                                <textarea name="description" class="form-control"
                                                    placeholder="Start typing here...">{!! $ad->description !!}</textarea>
                                                @error('description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="link">Ad URL *</label>
                                                <input type="url" value="{{ $ad->link }}" name="link" required
                                                    class="form-control" placeholder="Enter the ad link">
                                                @error('link')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="advert">Ad Image[Optional]</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="advert" name="advert">
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
                                                        <option {{ $ad->preset == $preset ? 'selected' : '' }}
                                                            value="{{ $preset }}">{{ $preset }}</option>
                                                    @endforeach
                                                </select>
                                                @error('preset')
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
                                    <div class="col-md-3 order-1 order-md-2 border-left">
                                        <div class="m-3">
                                            <h3 class="text-primary"><i class="fas fa-info-circle"></i> Ad Info</h3>
                                            <br>
                                            <div class="text-muted">
                                                <p class="text-sm">Ad Image
                                                    <img src="{{ $ad->featured() }}" class="img img-fluid">
                                                </p>
                                                <hr>
                                                <p class="text-sm">Last Updated
                                                    <b class="d-block">{{ $ad->updated_at }}</b>
                                                </p>
                                                <p class="text-sm">Created At
                                                    <b class="d-block">{{ $ad->created_at }}</b>
                                                </p>
                                            </div>
                                            <div class="mt-5 mb-3">
                                                <a class="btn btn-danger btn-sm"
                                                    onclick="confirmDeleteOperation('{{ route('admin_ads.destroy', $ad->id) }}', 'ad')"
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
    <script src="{{ asset('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $('#ads').select2();

        $(function() {
            bsCustomFileInput.init();
        });
    </script>
@endsection
