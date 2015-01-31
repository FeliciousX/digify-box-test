<?php

/**
 * Handles all user session for logging in and out
 */
class AuthController extends BaseController {

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
     * Login with Box OAuth 2.0
     */
    public function loginWithBox()
    {
        // get data from input
        $code = Input::get('code');
        $state = Input::get('state');


        // if code is provided, get user data and sign in
        if ( ! empty($code)) {
            // Callback request from Box, get the token
            $token = $this->box->requestAccessToken($code, $state);

            Session::put('token', $token);

            // Send a request with it
            $result = json_decode($this->box->request('/users/me'), true);

            $this->handleBoxLogin($token, $result);
            return Redirect::route('box.index');
        }
        // ask for permission first
        else {
            // get box authorization
            $url = $this->box->getAuthorizationUri();

            // return to Box login url
            return Redirect::to((string)$url);
        }
    }

    /**
     * handles login after having token and user data
     */
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

    public function logout()
    {
        // revoke the token
        $this->box->request('https://api.box.com/oauth2/revoke');
        Auth::logout();
        return Redirect::to('index');
    }
}
