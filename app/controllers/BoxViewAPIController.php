<?php

class BoxViewAPIController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($parentId)
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($parentId)
	{
		//
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
     * API Documentation (https://developers.box.com/viewing-your-first-document/)
     *
     * @param int $parentId
	 * @param  int  $fileId
	 * @return Response
	 */
	public function show($parentId, $fileId)
	{
        // only allow ajax
        if ( ! Request::ajax()) {
            App::abort(405, 'Method not allowed');
        }

        // make file downloadable
        $body = [
            'shared_link' => ['access' => 'open']
        ];
        $result = $this->box->request('/files/'.$fileId, 'PUT', json_encode($body));

        return Response::make($result, 200, ['Content-Type' => 'application/json']);

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
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($parentId, $id)
	{
		//
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
