<?php

/**
 * Uses the BoxView API
 * API Documentation (https://developers.box.com/viewing-your-first-document/)
 */
class BoxViewAPIController extends \BaseController {

    // Box View API Key
    protected $apiKey;
    // Box API that handles the displaying of listing files and folders
    protected $box;

    public function __construct()
    {
        $this->apiKey = Config::get('keys.api.box_view');

        // user Curl instead of StreamClient
        OAuth::setHttpClient('CurlClient');
        // get Box service
        $this->box = OAuth::consumer('Box', route('login'));
    }

	/**
	 * Make file sharable and get the file details
     * using file id
	 *
     * @param int $fileId
     *
	 * @return Response
	 */
	public function index($fileId)
	{
        // only allow ajax
        if ( ! Request::ajax()) {
            App::abort(405, 'Method not allowed');
        }

        $body = [
            'shared_link' => ['access' => 'open']
        ];
        $result = $this->box->request('/files/'.$fileId, 'PUT', json_encode($body));

        return Response::make($result, 200, ['Content-Type' => 'application/json']);

	}


	/**
	 * Queue the view from url and get the document id
     *
     * @param fileId
	 *
	 * @return Response
	 */
	public function create($fileId)
	{
        $url = Input::get('url');
        $client = new GuzzleHttp\Client();
        $r = $client->post('https://view-api.box.com/1/documents', [
            'headers' => ['Authorization' => 'Token '.$this->apiKey],
            'json' => ['url' => $url]
        ]);

        return Response::make($r->getBody(), 200, ['Content-Type' => 'application/json']);
	}


	/**
	 * Store a newly created resource in storage.
	 *
     * @param int $parentId
	 * @return Response
	 */
	public function store($parentId)
	{
        if (Input::hasFile('fileInput')) {

            $name = Input::get('fileName');
            $name = Str::slug($name, '_');
            $file = Input::file('fileInput');

            $validator = Validator::make([
                'fileName' => $name,
                'parentId' => $parentId,
            ],
            [
                'fileName' => 'required|alpha_dash',
                'parentId' => 'required|numeric'
            ]);

            if ($validator->fails())
            {
                Session::put('error', 'Invalid File Name');
                return Redirect::back();
            }

            $mime = $file->getClientOriginalExtension();

            // FAILS
            //$result = $this->box->request('https://upload.box.com/api/2.0/files/content', 'POST', $body);
            //
            /**
             * After trying a million different ways using Guzzle and OAuth Library, I resorted to this
             * It works like a charm. This is so annoying.
             * Filter everything!
             * TODO: @feliciousx use the PHP way. THIS IS SO DANGEROUS.
             */
            $accessToken = Session::get('token')->getAccessToken();

            $cmd = "curl https://upload.box.com/api/2.0/files/content ".
                '-H "Authorization: Bearer '.$accessToken. '" -X POST '.
                '-F attributes=\'{"name":"' .$name.'.'.$mime. '", "parent": {"id": "'.$parentId. '"}}\' '.
                "-F file=@".$file->getRealPath()." -v";

            $igaveup = shell_exec($cmd);
        }

        return Redirect::to(Request::server('HTTP_REFERER'));
	}


	/**
	 * Display the specified resource.
	 *
     *
     * @param int $parentId
	 * @param  int  $fileId
	 * @return Response
	 */
	public function show($sessionId, $fileId)
	{
        $url = "https://view-api.box.com/1/sessions/{$sessionId}/view?theme=light";

        return $url;
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($parentId, $id)
	{
		//
	}


	/**
	 * Get session from document id
	 *
     * @param  int  $fileId
	 * @param  int  $documentId
	 * @return Response
	 */
	public function update($fileId, $parentId)
	{
        $documentId = Input::get('documentId');
        $client = new GuzzleHttp\Client();
        $r = $client->post('https://view-api.box.com/1/sessions', [
            'headers' => ['Authorization' => 'Token '.$this->apiKey],
            'json' => ['document_id' => $documentId, 'duration' => 60]
        ]);

        return Response::json($r->getHeaders());
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($parentId, $id)
	{
		//
	}


}
