function confirmDeleteOperation(url, type) {
    $('#confirm-delete-form').attr('action', url);
    $('#confirm-delete-type').html(type);
    $("#confirm-delete-modal").modal('show');
}

function confirmRestoreOperation(url, type) {
    $('#confirm-restore-form').attr('action', url);
    $('#confirm-restore-type').html(type);
    $("#confirm-restore-modal").modal('show');
}

function confirmForceDeleteOperation(url, type) {
    $('#confirm-force-delete-form').attr('action', url);
    $('#confirm-force-delete-type').html(type);
    $("#confirm-force-delete-modal").modal('show');
}
