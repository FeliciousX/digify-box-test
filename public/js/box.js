function previewFile($id) {
    $('#previewPhoto').modal('show');
    var $img = $('<img />').attr('src', '/photo/'+$id);
    $img.addClass('img-responsive').addClass('img-thumbnail');

    $img.load(function() {
        $('#placeholder').append($img);
        $('#loader').hide();
    });
}

$(function(){
    $('#previewPhoto').on('hidden.bs.modal', function(e) {
        $('#placeholder').find('img').first().remove();
        $('#loader').show();
    });
});
