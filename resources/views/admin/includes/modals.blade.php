<div class="modal fade" id="confirm-delete-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirm Delete</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this <span id="confirm-delete-type"></span>?</p>
            </div>
            <form method="POST" class="modal-footer justify-content-between" id="confirm-delete-form">
                @csrf
                @method('DELETE')
                <a href="#" type="button" class="btn btn-default" data-dismiss="modal">Cancel</a>
                <button type="submit" class="btn btn-primary">Delete</button>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="logout-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirm Logout</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to leave?</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a type="button" href="{{ route('logout') }}" class="btn btn-primary">Logout</a>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="confirm-restore-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirm Restore</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to restore this <span id="confirm-restore-type"></span>?</p>
            </div>
            <form method="POST" class="modal-footer justify-content-between" id="confirm-restore-form">
                @csrf
                <a href="#" type="button" class="btn btn-default" data-dismiss="modal">Cancel</a>
                <button type="submit" class="btn btn-primary">Restore</button>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="confirm-force-delete-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirm Delete</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to permanently delete this <span id="confirm-force-delete-type"></span>?</p>
            </div>
            <form method="POST" class="modal-footer justify-content-between" id="confirm-force-delete-form">
                @csrf
                <a href="#" type="button" class="btn btn-default" data-dismiss="modal">Cancel</a>
                <button type="submit" class="btn btn-primary">Delete</button>
            </form>
        </div>
    </div>
</div>
