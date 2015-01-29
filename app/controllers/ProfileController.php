<?php

class ProfileController extends BaseController {

    protected $layout = 'master';

    // TODO: @feliciousx make a RESTful API for the API calls
	public function index()
	{
        $client = new GuzzleHttp\Client(['base_url' => 'https://api.box.com/2.0/']);
        $response = $client->get('users/me', [
            'headers' => [ 'Authorization' => 'Bearer '. Auth::user()->box_token ]
        ]);

        return View::make('pages.profile')->with('data', $data);
	}

}
