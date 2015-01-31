function previewFile($id) {
    // show spinner while image loads
    $('#loader').show();

    $('#previewPhoto').modal('show');
    var $img = $('<img />').attr('src', '/photo/'+$id);
    $img.addClass('img-responsive').addClass('img-thumbnail');

    // once image loads, hide spinner and show image
    $img.load(function() {
        $('#placeholder').append($img);
        $('#loader').hide();
    });
}

$(function(){
    $('#previewPhoto').on('hidden.bs.modal', function(e) {
        // when modal is hidden, remove image node to prepare for another image node
        $('#placeholder').find('img').first().remove();
    });
});
