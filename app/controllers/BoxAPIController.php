<?php

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
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $name = Input::get('name');
        $parent_id = Input::get('parent.id');

        $parent = ['id' => $parent_id];

        
        return Redirect::to(Session::pull('redirect'));
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $type = Input::get('type');

        if (strcmp($type, 'folder') == 0) {
            $result = json_decode($this->box->request('/folders/'.$id));
            View::share('folder', $result);
            return View::make('pages.box');
        }
        elseif (strcmp($type, 'file') == 0) {
            // TODO: @feliciousx use box view api to show
            /**
            $response = Response::make($this->box->request('/files/'.$id.'/content'), 200);
            $response->header('Content-Disposition', 'attachment; filename='.$id);
            $response->header('Content-Type', 'application/');
            return $response;
            **/
        }

        return Redirect::to(Session::pull('redirect'));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
