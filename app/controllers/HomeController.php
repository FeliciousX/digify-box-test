<?php

class HomeController extends BaseController {

    protected $layout = 'master';

	public function index()
	{
        return View::make('pages.home');
	}

}
