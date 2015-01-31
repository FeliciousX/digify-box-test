function previewFile($id) {
    $.ajax({
        type: 'GET',
        url: '/box/'+$id+'/edit'
    })
    .done(function($data) {
        $url = $data['shared_link']['download_url'];
        $apiKey = $data['api_key'];
        console.log($apiKey);

        $.ajax({
            type: 'POST',
            url: '',
            contentType: 'application/json',
            xhrFields: {
                withCredentials: false
            },
            // If you set any non-simple headers, your server must include these
            // headers in the 'Access-Control-Allow-Headers' response header.
            headers: {
                'Authorization': 'Token '+$apiKey
            },
            data: {
                'url': $url
            }
        })
        .done(function($data) {
            console.log($data);
        });

    });
}
