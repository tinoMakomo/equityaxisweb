@if (Session::has('error-message'))
        <div class="alert alert-warning messages-alert alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
            {{ Session::get('error-message') }}
        </div>
@endif

@if (Session::has('success-message'))
        <div class="alert alert-success messages-alert alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i> Success!</h5>
            {{ Session::get('success-message') }}
        </div>
@endif
