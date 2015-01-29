<?php

class AuthController extends BaseController {

    protected $layout = 'master';

    public function login()
    {
        $data = array();
        $data['message'] = array();

        if (Request::isMethod('post')) {
            $validator = Validator::make(Input::all(), array(
                'user.login' => 'required',
                'user.password' => 'required'
            ));

            if ($validator->passes()) {
                $credentials = array(
                    'login' => Input::get('user.login'),
                    'password' => Input::get('user.password')
                );

                if (Auth::attempt($credentials)) {
                    return Redirect::route('profile');
                }
            }

            Session::put('error', 'Username and/or password invalid.');
            return Redirect::back();
        }

        return View::make('pages.login', $data);
    }

    public function loginWithBox()
    {

        // get data from input
        $code = Input::get('code');

        // get Box service
        $box = OAuth::consumer('Box', route('login.box'));

        // check for code validity

        // if code is provided, get user data and sign in
        if ( ! empty($code)) {
            // Callback request from Box, get the token
            $token = $box->requestAccessToken($code, Input::get('state'));

            // Send a request with it
            $result = json_decode($box->request('/users/me'), true);

            // TODO: @feliciousx log user in
            // TODO: @feliciousx redirect user profile page
            Session::put('info', 'Your Box id is: ' . $result['id'] . ' and your name is ' . $result['name']);

            dd($result);

            Redirect::route('index');
        }
        // ask for permission first
        else {
            // get box authorization
            $url = $box->getAuthorizationUri();

            // return to Box login url
            return Redirect::to((string)$url);
        }
    }

    public function logout()
    {
        Auth::logout();

        return Redirect::route('login');
    }
}
