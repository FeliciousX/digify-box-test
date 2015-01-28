<?php

class ProfileController extends BaseController {

    protected $layout = 'master';

	public function index()
	{
        return View::make('pages.profile');
	}

}
