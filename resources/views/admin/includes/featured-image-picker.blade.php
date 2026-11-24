@php
    $isEdit = $isEdit ?? false;
    $currentImageUrl = old('existing_media_url') ?: ($isEdit && isset($post) ? $post->thumbnailSmall() : '');
    $hasInitialPreview = !empty($currentImageUrl);
@endphp

<div class="form-group">
    <label>Featured Image {{ $isEdit ? '[Optional — keep current or choose/upload a new one]' : '*' }}</label>

    <input type="hidden" name="existing_media_id" id="existing_media_id" value="{{ old('existing_media_id') }}">
    <input type="hidden" name="existing_media_url" id="existing_media_url" value="{{ old('existing_media_url') }}">

    <div>
        <button type="button" class="btn btn-outline-primary" id="openMediaLibraryBtn" data-toggle="modal" data-target="#mediaLibraryModal">
            <i class="fas fa-images mr-1"></i>
            {{ $isEdit ? 'Change / Upload Featured Image' : 'Select or Upload Featured Image' }}
        </button>
    </div>

    <div id="selectedImagePreviewWrap" class="mt-2 p-2 border rounded bg-light {{ $hasInitialPreview ? '' : 'd-none' }}" style="max-width: 340px;">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <small class="text-muted font-weight-bold" id="selectedImageBadge">
                @if (old('existing_media_id'))
                    Selected from uploaded photos
                @elseif ($isEdit && isset($post))
                    Current featured image
                @else
                    Selected image preview
                @endif
            </small>
            <button type="button" class="btn btn-xs btn-outline-danger {{ $isEdit && !old('existing_media_id') ? 'd-none' : '' }}" id="clearSelectedImageBtn">
                <i class="fas fa-times"></i> Clear
            </button>
        </div>
        <img id="selectedImagePreview" src="{{ $currentImageUrl }}" alt="Selected featured image preview" class="img-fluid rounded" style="max-height: 180px; width: 100%; object-fit: cover;">
    </div>

    @error('featured_image')
        <span class="text-danger d-block mt-1">{{ $message }}</span>
    @enderror
    @error('existing_media_id')
        <span class="text-danger d-block mt-1">{{ $message }}</span>
    @enderror
</div>

{{-- Combined Media Picker Modal: Uploaded Photos + Upload from PC --}}
<div class="modal fade" id="mediaLibraryModal" tabindex="-1" role="dialog" aria-labelledby="mediaLibraryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header pb-0 border-bottom-0">
                <h5 class="modal-title" id="mediaLibraryModalLabel">
                    <i class="fas fa-images mr-1"></i> Featured Image
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="px-3 pt-2 border-bottom">
                <ul class="nav nav-tabs border-bottom-0" id="mediaPickerTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab-existing-photos" data-toggle="tab" href="#pane-existing-photos" role="tab" aria-controls="pane-existing-photos" aria-selected="true">
                            <i class="fas fa-photo-video mr-1"></i> Uploaded Photos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-upload-pc" data-toggle="tab" href="#pane-upload-pc" role="tab" aria-controls="pane-upload-pc" aria-selected="false">
                            <i class="fas fa-upload mr-1"></i> Upload from PC
                        </a>
                    </li>
                </ul>
            </div>

            <div class="modal-body">
                <div class="tab-content" id="mediaPickerTabContent">
                    {{-- Tab 1: Already Uploaded Photos --}}
                    <div class="tab-pane fade show active" id="pane-existing-photos" role="tabpanel" aria-labelledby="tab-existing-photos">
                        <div class="input-group mb-3">
                            <input type="text" id="mediaLibrarySearch" class="form-control" placeholder="Search by image filename or post title...">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" id="mediaLibrarySearchBtn">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </div>

                        <div id="mediaLibraryLoading" class="text-center py-5 d-none">
                            <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                            <p class="text-muted mt-2 mb-0">Loading uploaded photos...</p>
                        </div>

                        <div id="mediaLibraryEmpty" class="text-center py-5 text-muted d-none">
                            <i class="far fa-images fa-2x mb-2"></i>
                            <p class="mb-2">No uploaded photos found.</p>
                            <button type="button" class="btn btn-sm btn-primary" id="switchToUploadTabBtn">
                                <i class="fas fa-upload mr-1"></i> Upload from PC instead
                            </button>
                        </div>

                        <div id="mediaLibraryGrid" class="row"></div>
                    </div>

                    {{-- Tab 2: Upload New Photo from PC --}}
                    <div class="tab-pane fade" id="pane-upload-pc" role="tabpanel" aria-labelledby="tab-upload-pc">
                        <div id="pcUploadDropzone" class="media-upload-dropzone text-center p-5 rounded">
                            <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                            <h5 class="mb-1">Drag &amp; drop an image here</h5>
                            <p class="text-muted small mb-3">JPG, PNG, WEBP or GIF &bull; Maximum size 2 MB</p>
                            <button type="button" class="btn btn-primary" id="triggerPcFileBtn">
                                <i class="fas fa-folder-open mr-1"></i> Browse Computer
                            </button>
                            <input type="file" class="d-none" id="featured_image" name="featured_image" accept="image/*">
                            <div id="pcUploadError" class="text-danger small mt-3 d-none"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer justify-content-between">
                <div class="text-muted small" id="mediaLibraryMeta"></div>
                <div>
                    <span id="mediaLibraryPagination">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="mediaLibraryPrevBtn" disabled>
                            <i class="fas fa-chevron-left"></i> Previous
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary ml-1" id="mediaLibraryNextBtn" disabled>
                            Next <i class="fas fa-chevron-right"></i>
                        </button>
                    </span>
                    <button type="button" class="btn btn-sm btn-secondary ml-2" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .media-picker-card {
        cursor: pointer;
        transition: transform 0.12s ease, box-shadow 0.12s ease, border-color 0.12s ease;
        border: 2px solid transparent;
    }
    .media-picker-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        border-color: #007bff;
    }
    .media-picker-card.is-selected {
        border-color: #28a745;
        box-shadow: 0 0 0 2px rgba(40, 167, 69, 0.25);
    }
    .media-picker-thumb {
        height: 130px;
        width: 100%;
        object-fit: cover;
        background-color: #f4f6f9;
    }
    .media-upload-dropzone {
        border: 2px dashed #adb5bd;
        background-color: #f8f9fa;
        cursor: pointer;
        transition: border-color 0.15s ease, background-color 0.15s ease;
    }
    .media-upload-dropzone:hover,
    .media-upload-dropzone.is-dragover {
        border-color: #007bff;
        background-color: #eaf4ff;
    }
</style>

@push('featured_image_picker_scripts')
<script>
    (function($) {
        var libraryUrl = @json(route('admin.media.library'));
        var isEditMode = @json((bool) $isEdit);
        var originalEditImageUrl = @json($isEdit && isset($post) ? $post->thumbnailSmall() : '');
        var currentPage = 1;
        var lastPage = 1;
        var searchTimer = null;
        var maxFileBytes = 2 * 1024 * 1024; // 2 MB

        function escapeHtml(text) {
            return $('<div>').text(text || '').html();
        }

        function setPreview(url, badgeText, showClear) {
            $('#selectedImagePreview').attr('src', url);
            $('#selectedImageBadge').text(badgeText);
            $('#selectedImagePreviewWrap').removeClass('d-none');
            $('#clearSelectedImageBtn').toggleClass('d-none', !showClear);
        }

        function clearAllSelection() {
            $('#existing_media_id').val('');
            $('#existing_media_url').val('');
            $('#featured_image').val('');
            $('#pcUploadError').addClass('d-none').text('');

            if (isEditMode && originalEditImageUrl) {
                setPreview(originalEditImageUrl, 'Current featured image', false);
            } else {
                $('#selectedImagePreview').attr('src', '');
                $('#selectedImagePreviewWrap').addClass('d-none');
            }
        }

        function handlePickedFile(file) {
            var $err = $('#pcUploadError');
            $err.addClass('d-none').text('');

            if (!file) {
                return;
            }
            if (!file.type || file.type.indexOf('image/') !== 0) {
                $err.removeClass('d-none').text('Please select a valid image file (JPG, PNG, WEBP, or GIF).');
                $('#featured_image').val('');
                return;
            }
            if (file.size > maxFileBytes) {
                $err.removeClass('d-none').text('Image is larger than 2 MB. Please choose a smaller image.');
                $('#featured_image').val('');
                return;
            }

            $('#existing_media_id').val('');
            $('#existing_media_url').val('');

            if (window.FileReader) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    setPreview(e.target.result, 'New upload from PC: ' + file.name, true);
                    $('#mediaLibraryModal').modal('hide');
                };
                reader.readAsDataURL(file);
            } else {
                $('#mediaLibraryModal').modal('hide');
            }
        }

        function loadMediaLibrary(page) {
            currentPage = page || 1;
            var query = $.trim($('#mediaLibrarySearch').val());

            $('#mediaLibraryLoading').removeClass('d-none');
            $('#mediaLibraryEmpty').addClass('d-none');
            $('#mediaLibraryGrid').empty();

            $.getJSON(libraryUrl, { page: currentPage, q: query })
                .done(function(res) {
                    $('#mediaLibraryLoading').addClass('d-none');
                    lastPage = res.last_page || 1;
                    var selectedId = String($('#existing_media_id').val() || '');

                    if (!res.data || res.data.length === 0) {
                        $('#mediaLibraryEmpty').removeClass('d-none');
                        $('#mediaLibraryMeta').text('0 photos');
                        $('#mediaLibraryPrevBtn').prop('disabled', true);
                        $('#mediaLibraryNextBtn').prop('disabled', true);
                        return;
                    }

                    var html = '';
                    res.data.forEach(function(item) {
                        var isSelected = selectedId === String(item.id);
                        var caption = item.post_title ? item.post_title : item.file_name;
                        html +=
                            '<div class="col-6 col-sm-4 col-md-3 mb-3">' +
                                '<div class="card h-100 mb-0 media-picker-card ' + (isSelected ? 'is-selected' : '') + '"' +
                                    ' data-id="' + item.id + '"' +
                                    ' data-url="' + escapeHtml(item.thumb_url) + '"' +
                                    ' data-name="' + escapeHtml(item.file_name) + '">' +
                                    '<img src="' + escapeHtml(item.thumb_url) + '" loading="lazy" class="card-img-top media-picker-thumb" alt="' + escapeHtml(item.name) + '">' +
                                    '<div class="card-body p-2">' +
                                        '<div class="small text-truncate font-weight-bold" title="' + escapeHtml(caption) + '">' + escapeHtml(caption) + '</div>' +
                                        '<div class="text-muted" style="font-size: 11px;">' + escapeHtml(item.created_at || '') + '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';
                    });

                    $('#mediaLibraryGrid').html(html);
                    $('#mediaLibraryMeta').text('Page ' + res.current_page + ' of ' + res.last_page + ' (' + res.total + ' photos)');
                    $('#mediaLibraryPrevBtn').prop('disabled', res.current_page <= 1);
                    $('#mediaLibraryNextBtn').prop('disabled', res.current_page >= res.last_page);
                })
                .fail(function() {
                    $('#mediaLibraryLoading').addClass('d-none');
                    $('#mediaLibraryEmpty').removeClass('d-none').find('p').text('Failed to load uploaded photos. Please try again.');
                });
        }

        // Open modal -> show Uploaded Photos tab & refresh grid
        $('#mediaLibraryModal').on('show.bs.modal', function() {
            $('#pcUploadError').addClass('d-none').text('');
            $('#tab-existing-photos').tab('show');
            loadMediaLibrary(1);
        });

        // Toggle footer pagination visibility depending on active tab
        $('a[data-toggle="tab"]', '#mediaPickerTabs').on('shown.bs.tab', function(e) {
            var isUploadTab = $(e.target).attr('id') === 'tab-upload-pc';
            $('#mediaLibraryPagination').toggleClass('d-none', isUploadTab);
            $('#mediaLibraryMeta').toggleClass('d-none', isUploadTab);
        });

        $('#switchToUploadTabBtn').on('click', function() {
            $('#tab-upload-pc').tab('show');
        });

        // Click a photo card to select it
        $(document).on('click', '.media-picker-card', function() {
            var id = $(this).data('id');
            var url = $(this).data('url');

            $('#featured_image').val('');
            $('#existing_media_id').val(id);
            $('#existing_media_url').val(url);

            setPreview(url, 'Selected from uploaded photos', true);
            $('#mediaLibraryModal').modal('hide');
        });

        // Upload from PC: click dropzone or button -> open OS file dialog
        $('#triggerPcFileBtn').on('click', function(e) {
            e.stopPropagation();
            $('#featured_image').trigger('click');
        });

        $('#pcUploadDropzone').on('click', function(e) {
            if ($(e.target).is('#featured_image')) {
                return;
            }
            $('#featured_image').trigger('click');
        });

        $('#featured_image').on('change', function() {
            var file = this.files && this.files[0];
            handlePickedFile(file);
        });

        // Drag-and-drop onto PC upload dropzone
        $('#pcUploadDropzone')
            .on('dragover dragenter', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).addClass('is-dragover');
            })
            .on('dragleave dragend drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('is-dragover');
            })
            .on('drop', function(e) {
                var files = e.originalEvent && e.originalEvent.dataTransfer ? e.originalEvent.dataTransfer.files : null;
                if (files && files.length > 0) {
                    var input = document.getElementById('featured_image');
                    if (window.DataTransfer) {
                        var dt = new DataTransfer();
                        dt.items.add(files[0]);
                        input.files = dt.files;
                    }
                    handlePickedFile(files[0]);
                }
            });

        // Clear selection button
        $('#clearSelectedImageBtn').on('click', clearAllSelection);

        // Search & pagination
        $('#mediaLibrarySearchBtn').on('click', function() {
            loadMediaLibrary(1);
        });
        $('#mediaLibrarySearch').on('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                clearTimeout(searchTimer);
                loadMediaLibrary(1);
            }
        });
        $('#mediaLibrarySearch').on('keyup', function(e) {
            if (e.key === 'Enter') {
                return;
            }
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function() {
                loadMediaLibrary(1);
            }, 350);
        });
        $('#mediaLibraryPrevBtn').on('click', function() {
            if (currentPage > 1) {
                loadMediaLibrary(currentPage - 1);
            }
        });
        $('#mediaLibraryNextBtn').on('click', function() {
            if (currentPage < lastPage) {
                loadMediaLibrary(currentPage + 1);
            }
        });
    })(jQuery);
</script>
@endpush
