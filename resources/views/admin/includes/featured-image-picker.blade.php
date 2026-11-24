@php
    $isEdit = $isEdit ?? false;
@endphp

<div class="form-group">
    <label for="featured_image">Featured Image {{ $isEdit ? '[Optional — keep current, upload new, or choose existing]' : '*' }}</label>

    <input type="hidden" name="existing_media_id" id="existing_media_id" value="{{ old('existing_media_id') }}">
    <input type="hidden" name="existing_media_url" id="existing_media_url" value="{{ old('existing_media_url') }}">

    <div class="d-flex flex-wrap align-items-center mb-2" style="gap: 0.5rem;">
        <div class="custom-file flex-grow-1" style="min-width: 240px;">
            <input type="file" class="custom-file-input" id="featured_image" name="featured_image" accept="image/*">
            <label class="custom-file-label" for="featured_image" id="featured_image_label">Upload new image...</label>
        </div>
        <button type="button" class="btn btn-outline-primary" id="openMediaLibraryBtn" data-toggle="modal" data-target="#mediaLibraryModal">
            <i class="fas fa-images mr-1"></i> Choose from Uploaded Photos
        </button>
    </div>

    <div id="selectedImagePreviewWrap" class="mt-2 p-2 border rounded bg-light {{ old('existing_media_url') ? '' : 'd-none' }}" style="max-width: 340px;">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <small class="text-muted font-weight-bold" id="selectedImageBadge">
                {{ old('existing_media_id') ? 'Selected from uploaded photos' : 'Selected image preview' }}
            </small>
            <button type="button" class="btn btn-xs btn-outline-danger" id="clearSelectedImageBtn">
                <i class="fas fa-times"></i> Clear
            </button>
        </div>
        <img id="selectedImagePreview" src="{{ old('existing_media_url') }}" alt="Selected featured image preview" class="img-fluid rounded" style="max-height: 180px; width: 100%; object-fit: cover;">
    </div>

    @error('featured_image')
        <span class="text-danger d-block mt-1">{{ $message }}</span>
    @enderror
    @error('existing_media_id')
        <span class="text-danger d-block mt-1">{{ $message }}</span>
    @enderror
</div>

{{-- Uploaded Photos Library Modal --}}
<div class="modal fade" id="mediaLibraryModal" tabindex="-1" role="dialog" aria-labelledby="mediaLibraryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediaLibraryModalLabel">
                    <i class="fas fa-images mr-1"></i> Choose from Uploaded Photos
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
                    <p class="mb-0">No uploaded photos found.</p>
                </div>

                <div id="mediaLibraryGrid" class="row"></div>
            </div>
            <div class="modal-footer justify-content-between">
                <div class="text-muted small" id="mediaLibraryMeta"></div>
                <div>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="mediaLibraryPrevBtn" disabled>
                        <i class="fas fa-chevron-left"></i> Previous
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary ml-1" id="mediaLibraryNextBtn" disabled>
                        Next <i class="fas fa-chevron-right"></i>
                    </button>
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
</style>

@push('featured_image_picker_scripts')
<script>
    (function($) {
        var libraryUrl = @json(route('admin.media.library'));
        var currentPage = 1;
        var lastPage = 1;
        var searchTimer = null;

        function escapeHtml(text) {
            return $('<div>').text(text || '').html();
        }

        function setPreview(url, badgeText) {
            $('#selectedImagePreview').attr('src', url);
            $('#selectedImageBadge').text(badgeText);
            $('#selectedImagePreviewWrap').removeClass('d-none');
        }

        function clearAllSelection() {
            $('#existing_media_id').val('');
            $('#existing_media_url').val('');
            $('#featured_image').val('');
            $('#featured_image_label').text('Upload new image...');
            $('#selectedImagePreview').attr('src', '');
            $('#selectedImagePreviewWrap').addClass('d-none');
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

        // Open modal -> load latest photos
        $('#mediaLibraryModal').on('show.bs.modal', function() {
            loadMediaLibrary(1);
        });

        // Click a photo card to select it
        $(document).on('click', '.media-picker-card', function() {
            var id = $(this).data('id');
            var url = $(this).data('url');
            var name = $(this).data('name');

            // Clear file input so existing_media_id is used
            $('#featured_image').val('');
            $('#featured_image_label').text('Using library photo: ' + name);
            $('#existing_media_id').val(id);
            $('#existing_media_url').val(url);

            setPreview(url, 'Selected from uploaded photos');
            $('#mediaLibraryModal').modal('hide');
        });

        // Choosing a new local file clears existing_media_id and previews the file
        $('#featured_image').on('change', function() {
            var file = this.files && this.files[0];
            if (!file) {
                return;
            }
            $('#existing_media_id').val('');
            $('#existing_media_url').val('');
            $('#featured_image_label').text(file.name);

            if (window.FileReader) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    setPreview(e.target.result, 'New image to upload: ' + file.name);
                };
                reader.readAsDataURL(file);
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
