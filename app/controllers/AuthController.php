<?php

class AuthController extends BaseController {

    protected $layout = 'master';

    public function loginWithBox() {

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

            // TODO: @feliciousx redirect user to file listing
            $message = 'Your Box id is: ' . $result['id'] . ' and your name is ' . $result['name'];
            echo $message . "<br/>";

            dd($result);
        }
        // ask for permission first
        else {
            // get box authorization
            $url = $box->getAuthorizationUri();

            // return to Box login url
            return Redirect::to((string)$url);
        }
    }

}
