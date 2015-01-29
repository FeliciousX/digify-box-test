<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('box_token', 'refresh_token', 'remember_token');

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function getReminderEmail()
    {
        return $this->login;
    }

    public function getBoxToken()
    {
        return $this->box_token;
    }

    public function setBoxToken($value)
    {
        $this->box_token = $value;
    }

    public function getRefreshToken()
    {
        return $this->refresh_token;
    }

    public function setRefreshToken($value)
    {
        $this->refresh_token = $value;
    }

    public static function handleBoxLogin($token, $data)
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
}
