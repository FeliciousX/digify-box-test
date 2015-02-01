$(function(){
    $('#previewPhoto').on('hidden.bs.modal', function(e) {
        // when modal is hidden, remove image node to prepare for another image node
        $('#placeholder').find('img').first().remove();
    });
});

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

function deleteFile($id) {
    if (confirm('Is it OK to delete this item?')) {
        $.ajax({
            url: '/photo/'+$id,
            type: 'DELETE',
        })
        .done(function($res) {
            $('#item_'+$id).remove();
        })
        .fail(function($e) {
            alert('Oops! Something went wrong while trying to delete file.');
        });
    }
}

function deleteFolder($id) {
    if (confirm('Is it OK to delete this folder? (And everything inside)')) {
        $.ajax({
            url: '/box/'+$id,
            type: 'DELETE',
        })
        .done(function($res) {
            $('#item_'+$id).remove();
        })
        .fail(function($e) {
            alert('Oops! Something went wrong while trying to delete folder.');
        });
    }
}
