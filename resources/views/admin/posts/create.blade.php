@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Create Post</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Create Post</li>
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
                                        <form class="form-horizontal m-4" action="{{ route('admin_posts.store') }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="title">Title *</label>
                                                <input type="text" name="title" required class="form-control"
                                                    placeholder="Enter the post title">
                                                @error('title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="body" class="col-form-control-label">Post Body *</label>
                                                <textarea name="body" id="rich-text-editor" placeholder="Start typing here..."></textarea>
                                                @error('body')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="excerpt">Excerpt *</label>
                                                <input maxlength="200" pattern=".{160,}"
                                                    title="The excerpt should not be less than 160 characters."
                                                    type="text" name="excerpt" required class="form-control"
                                                    placeholder="Enter the post excerpt, up to 200 characters">
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
                                                        <option value="{{ $category->id }}">{{ $category->name }}
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
                                                    <option {{ old('status') == 'draft' ? 'selected' : '' }} value="draft"
                                                        {{ old('status') ?? 'selected' }}>Draft</option>
                                                    <option {{ old('status') == 'published' ? 'selected' : '' }}
                                                        value="published">
                                                        Published</option>
                                                    <option {{ old('status') == 'not_published' ? 'selected' : '' }}
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
                                                        <option value="0">No</option>
                                                        <option value="1">Yes</option>
                                                    </select>
                                                    @error('editors_pick')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="is_archived">Is Archived * </label>
                                                    <select class="form-control custom-select" name="is_archived"
                                                        required="">
                                                        <option value="0">No</option>
                                                        <option value="1">Yes</option>
                                                    </select>
                                                    @error('is_archived')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            @endif

                                            <div class="form-group">
                                                <label for="featured_image">Featured Image *</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="featured_image"
                                                        name="featured_image">
                                                    <label class="custom-file-label" for="featured_image">Choose
                                                        file</label>
                                                </div>
                                                @error('featured_image')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="tags">Tags [Optional]</label>
                                                <select name="tags[]" id="tags" class="form-control"
                                                    multiple="multiple" data-placeholder="Add post tags"
                                                    style="width: 100%;"></select>
                                                @error('tags')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="publish_at">Publish At [Optional]</label>
                                                <div class="input-group date" id="publish_at"
                                                    data-target-input="nearest">
                                                    <input name="publish_at" type="text"
                                                        placeholder="Select publish date & time"
                                                        class="form-control datetimepicker-input"
                                                        data-target="#publish_at" />
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
                                                        <option @if (old('author') == null && $user->id == auth()->user()->id) selected="true" @endif
                                                            value="{{ $user->id }}">{{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('author')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-save">
                                                        </i>
                                                        Create Post
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
@endsection
