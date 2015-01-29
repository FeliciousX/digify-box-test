<?php

Use OAuth\Common\Http\Exception\TokenResponseException;

class AuthController extends BaseController {

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
        $state = Input::get('state');

        // user Curl instead of StreamClient
        OAuth::setHttpClient('CurlClient');
        // get Box service
        $box = OAuth::consumer('Box', route('login.box'));

        // if code is provided, get user data and sign in
        if ( ! empty($code)) {
            // Callback request from Box, get the token
            $token = $box->requestAccessToken($code, $state);

            // Send a request with it
            $result = json_decode($box->request('/users/me'), true);

            $this->handleBoxLogin($token, $result);
            return Redirect::route('profile');
        }
        // ask for permission first
        else {
            // get box authorization
            $url = $box->getAuthorizationUri();

            // return to Box login url
            return Redirect::to((string)$url);
        }
    }

    public function handleBoxLogin($token, $data)
    {
        if (empty($token)) throw new Exception('No token received');
        if (empty($data)) throw new Exception('No user data given');

        $login = $data['login'];
        $name = $data['name'];
        $box_token = $token->getAccessToken();

        // try to find if user exist
        $user = User::where('login', '=', $login)->first();

        if ( ! $user) {
            // user don't exist, create a new user
            $user = new User();
            $user->name = $name;
            $user->login = $login;
            $user->password = Hash::make($box_token);

        }

        $user->setBoxToken($box_token);

        if ($token->getRefreshToken())
            $user->setRefreshToken($token->getRefreshToken());

        $user->save();

        // Log user in
        Auth::login($user);
    }

    // TODO: @feliciousx revoke access token aswell
    public function logout()
    {
        Auth::logout();

        return Redirect::route('login');
    }
}
