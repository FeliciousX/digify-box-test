<?php

use GuzzleHttp\Post\PostFile;

class BoxAPIController extends \BaseController {

    // Box API that handles the displaying of listing files and folders
    protected $box;

    public function __construct()
    {
        // user Curl instead of StreamClient
        OAuth::setHttpClient('CurlClient');
        // get Box service
        $this->box = OAuth::consumer('Box', route('login'));
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $result = json_decode($this->box->request('/folders/0'));

        View::share('folder', $result);
        return View::make('pages.box');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a new folder
     *
	 * @return Response
	 */
	public function store()
	{
        $name = Input::get('folderName');
        $id = Input::get('parentId');

        // build body
        $body = [
            'name' => $name,
            'parent' => [ 'id' => $id ]
        ];

        // using Box Service works :)
        $result = $this->box->request('folders', 'POST', json_encode($body));

        /** using Guzzle works too :)
        $accessToken = Session::get('token')->getAccessToken();
        $client = new GuzzleHttp\Client();
        $r = $client->post('https://api.box.com/2.0/folders', [
            'headers' => ['Authorization' => 'Bearer '.$accessToken],
            'json' => $body
        ]);
        **/
        return Redirect::to(Request::server('HTTP_REFERER'));
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $result = json_decode($this->box->request('/folders/'.$id));
        View::share('folder', $result);
        return View::make('pages.box');
	}


	/**
	 * Show the form for editing the specified resource.
     *
     * API Documentation (https://developers.box.com/viewing-your-first-document/)
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        // only allow ajax
        if ( ! Request::ajax()) {
            App::abort(405, 'Method not allowed');
        }

        // make file downloadable
        $body = [
            'shared_link' => ['access' => 'open']
        ];
        $result = $this->box->request('/files/'.$id, 'PUT', json_encode($body));
        $decode = json_decode($result);
        // append view api key
        $decode->api_key = Config::get('keys.api.box_view');

        // get file's details
        return Response::json($decode);

        /** Use javascript :)
        $client = new GuzzleHttp\Client();
        $accessToken = Config::get('keys.api.box_view');
        $r = $client->post('https://view-api.box.com/1/documents', [
            'headers' => ['Authorization' => 'Token '.$accessToken],
            'json' => ['url' => $url]
        ]);

        $res = json_decode($r->getBody());

        $r = $client->post('https://view-api.box.com/1/sessions', [
            'headers' => ['Authorization' => 'Token '.$accessToken],
            'json' => ['document_id' => $res->id, 'duration' => 60]
        ]);
        **/

	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        if (Input::hasFile('fileInput')) {

            $name = Input::get('fileName');
            $name = Str::slug($name, '_');
            $parent_id = Input::get('parentId');
            $file = Input::file('fileInput');

            $validator = Validator::make([
                'fileName' => $name,
                'parentId' => $parent_id,
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

            // prepare data for upload
            $mime = $file->getClientOriginalExtension();
            /**
            $attributes = [
                'name' => $name,
                'parent' => [ 'id' => $parent_id ]
            ];
            **/

            //$body = ['attributes' => json_encode($attributes), 'file' => fopen($file, 'r')];

            /** FAILS
            $client = new GuzzleHttp\Client();
            $r = $client->post('https://upload.box.com/2.0/files/content', [
                'headers' => ['Authorization' => 'Bearer '.$accessToken],
                'body' => $body
            ]);
            **/

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
                '-F attributes=\'{"name":"' .$name.'.'.$mime. '", "parent": {"id": "'.$parent_id. '"}}\' '.
                "-F file=@".$file->getRealPath()." -v";

            $igaveup = shell_exec($cmd);
        }

        return Redirect::to(Request::server('HTTP_REFERER'));
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
