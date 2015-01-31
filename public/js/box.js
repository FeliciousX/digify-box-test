function previewFile($id) {
    $('#currentPhoto').attr('src', '/photo/'+$id);

    $('#previewPhoto').modal('show');
}
