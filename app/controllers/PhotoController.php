<?php

class PhotoController extends \BaseController {

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
		//
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
        if (Input::hasFile('fileInput')) {
            $parentId = Input::get('parentId');
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
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $body = [
            'shared_link' => ['access' => 'open']
        ];
        $data = $this->box->request('/files/'.$id, 'PUT', json_encode($body));
        $data = json_decode($data);

        $result = $this->box->request('/files/'.$id.'/content');

        $mime =  $this->guess_mimetype($data->name);
        return Response::make($result, 200, ['Content-Type' => $mime]);
	}

    /**
     * From most documentations online, there are currently no good way to guess mimetype.
     * PHP's  mime_content_type() is deprecated, FileInfo is unreliable and finally Box API
     * doesn't provide the mimetype of the files.
     *
     * Workaround for now..
     */
    protected function guess_mimetype($name)
    {
        $pos = strrpos($name, '.');
        $ext = substr($name, $pos);
        if (str_is($ext, 'jp[e,g]+')) {
            return 'image/jpeg';
        }

        if (str_is($ext, 'png')) {
            return 'image/png';
        }

        if (str_is($ext, 'svg')) {
            return 'image/svg+xml';
        }

        if (str_is($ext, 'bmp')) {
            return 'image/bmp';
        }

        if (str_is($ext, 'gif')) {
            return 'image/gif';
        }

        if (str_is($ext, 'ico')) {
            return 'image/x-icon';
        }
        return 'text/plain';
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
        $data = $this->box->request('/files/'.$id, 'DELETE');
        return Response::make(null, 204);
	}


}
