@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Post Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Posts</a></li>
                            <li class="breadcrumb-item active">Post Details</li>
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
                                <h3 class="card-title pt-2">{{ $post->title }}</h3>

                            </div>
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-md-9">
                                        <form class="form-horizontal m-4"
                                            action="{{ route('admin_posts.update', $post->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @method('PUT')
                                            @csrf
                                            <div class="form-group">
                                                <label for="title">Title *</label>
                                                <input type="text" name="title" required class="form-control"
                                                    placeholder="Enter the post title" value="{{ $post->title }}">
                                                @error('title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="body" class="col-form-control-label">Post Body *</label>
                                                <textarea name="body" id="rich-text-editor" placeholder="Start typing here...">{!! $post->body !!}</textarea>
                                                @error('body')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="excerpt">Excerpt *</label>
                                                <input maxlength="200" pattern=".{160,}"
                                                    title="The excerpt should not be less than 160 characters."
                                                    type="text" name="excerpt" required class="form-control"
                                                    placeholder="Enter the post excerpt" value="{{ $post->excerpt }}">
                                                @error('excerpt')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="categories">Post Category/Categories
                                                    *</label>
                                                <select id="categories" multiple="multiple"
                                                    data-placeholder="Select post category(ies)" class="form-control"
                                                    name="categories[]" required>
                                                    <option value="">Select Category/Categories...</option>
                                                    @foreach (\App\Models\Category::all() as $category)
                                                        <option
                                                            {{ $post->categories->pluck('id')->contains($category->id) ? 'selected' : '' }}
                                                            value="{{ $category->id }}">{{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('categories')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="status">Status * </label>
                                                <select class="form-control custom-select" name="status" required="">
                                                    <option {{ $post->status == 'draft' ? 'selected' : '' }} value="draft"
                                                        {{ old('status') ?? 'selected' }}>Draft</option>
                                                    <option {{ $post->status == 'published' ? 'selected' : '' }}
                                                        value="published">
                                                        Published</option>
                                                    <option {{ $post->status == 'not_published' ? 'selected' : '' }}
                                                        value="not_published">
                                                        Not Published</option>
                                                </select>
                                                @error('status')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            @if (auth()->user()->isAdmin() ||
                                                    auth()->user()->isEditor())
                                                <div class="form-group">
                                                    <label for="editors_pick">Editors Pick * </label>
                                                    <select class="form-control custom-select" name="editors_pick"
                                                        required="">
                                                        <option {{ $post->editors_pick == '0' ? 'selected' : '' }}
                                                            value="0">No</option>
                                                        <option {{ $post->editors_pick == '1' ? 'selected' : '' }}
                                                            value="1">Yes</option>
                                                    </select>
                                                    @error('editors_pick')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="is_archived">Is Archived * </label>
                                                    <select class="form-control custom-select" name="is_archived"
                                                        required="">
                                                        <option {{ $post->is_archived == '0' ? 'selected' : '' }}
                                                            value="0">No</option>
                                                        <option {{ $post->is_archived == '1' ? 'selected' : '' }}
                                                            value="1">Yes</option>
                                                    </select>
                                                    @error('is_archived')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            @endif
                                            @include('admin.includes.featured-image-picker', ['isEdit' => true])
                                            <div class="form-group">
                                                <label for="tags">Tags [Optional]</label>
                                                <select name="tags[]" id="tags" class="form-control"
                                                    multiple="multiple" data-placeholder="Add post tags"
                                                    style="width: 100%;">
                                                    @foreach ($post->tags() as $tag)
                                                        <option selected value="{{ $tag }}">{{ $tag }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('tags')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="publish_at">Publish At [Optional]</label>
                                                <div class="input-group date" id="publish_at"
                                                    data-target-input="nearest">
                                                    <input value="{{ $post->publish_at }}" name="publish_at"
                                                        type="text" placeholder="Select publish date & time"
                                                        class="form-control datetimepicker-input"
                                                        data-target="#publish_at" data-toggle="datetimepicker" />
                                                    <div class="input-group-append" data-target="#publish_at"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                                @error('publish_at')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="{{ auth()->user()->isAdmin()? '': 'd-none' }} form-group">
                                                <label for="author">Select Author * </label>
                                                <select id="author" data-placeholder="Select article author"
                                                    class="form-control" name="author" required>
                                                    <option value="">Select Author...</option>
                                                    @foreach (\App\Models\User::all() as $user)
                                                        <option @if (old('author') == null && $user->id == $post->user_id) selected="true" @endif
                                                            value="{{ $user->id }}">{{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('author')
                                                    <div class="text-danger">{{ $message }}</div>
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
                                            <h3 class="text-primary"><i class="fas fa-info-circle"></i> Post Info</h3>
                                            <br>
                                            <div class="text-muted">
                                                <p class="text-sm">Featured Image
                                                    <img src="{{ $post->thumbnailSmall() }}" class="img img-fluid">
                                                </p>
                                                <hr>
                                                <p class="text-sm">Post Views
                                                    <b class="d-block">Views: {{ $meta['hits'] }}, Unique Visitors:
                                                        {{ $meta['unique_hits'] }}</b>
                                                </p>
                                                <hr>
                                                <p class="text-sm">Post Author
                                                    <b class="d-block">{{ optional($post->user)->name ?? 'Unknown Author' }}</b>
                                                </p>
                                                <hr>
                                                <p class="text-sm">Last Updated
                                                    <b class="d-block">{{ $post->updated_at }}</b>
                                                </p>
                                                <p class="text-sm">Created At
                                                    <b class="d-block">{{ $post->created_at }}</b>
                                                </p>
                                            </div>
                                            <div class="mt-5 mb-3">
                                                <a class="btn btn-danger btn-sm"
                                                    onclick="confirmDeleteOperation('{{ route('admin_posts.destroy', $post->id) }}', 'post')"
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
    <script src="{{ asset('admin/plugins/tinymce/tinymce.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('admin/plugins/select2/css/select2.min.css') }}">
@endsection

@section('styles')
    <link rel="stylesheet"
        href="{{ asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
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
                format: 'YYYY-MM-DD HH:mm:ss',
                defaultDate: moment().format(),
            });
        });

        $('#categories').select2();

        $('#author').select2();


        $('#tags').select2({
            'tags': true,
            'tokenSeparators': ['|', ',']
        })



        tinymce.init({
            selector: 'textarea#rich-text-editor',
            height: 500,
            menubar: false,
            plugins: "lists",
            plugins: [
                'link',
                'lists'
            ],
            contextmenu: false,
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | link | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });

        $(function() {
            bsCustomFileInput.init();
        });
    </script>
    @stack('featured_image_picker_scripts')
@endsection
