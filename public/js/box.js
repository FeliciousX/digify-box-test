function previewFile($id) {
    $.ajax({
        type: 'GET',
        url: '/box/'+$id+'/view'
    })
    .done(function($data) {
        $url = $data['shared_link']['download_url'];

        $.ajax({
            type: 'GET',
            url: '/box/'+$id+'/view/create?url='+$url,
        })
        .done(function($doc) {
            $documentId = $doc['id'];
            
            $.ajax({
                type: 'PUT',
                url: '/box/'+$id+'/view/'+$id,
                data: {
                    'documentId': $documentId
                }
            })
            .done(function($sess) {
                console.log($sess);
            });
        });

    });
}
