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
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $result = $this->box->request('/folders/'.$id.'?recursive=true', 'DELETE');
        return Response::make(null, 204);
	}


}
