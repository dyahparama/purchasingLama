<?php
// namespace Api\Login;
use SilverStripe\Security\PasswordEncryptor_Blowfish;

class Auth
{
    /**
     * An array of actions that can be accessed via a request. Each array element should be an action name, and the
     * permissions or conditions required to allow the user to access it.
     *
     * <code>
     * [
     *     'action', // anyone can access this action
     *     'action' => true, // same as above
     *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
     *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
     * ];
     * </code>
     *
     * @var array
     */

    public function encrypt($input)
    {
        $enc = new PasswordEncryptor_Blowfish();
        $salt = $enc->salt($input);
        $val = $enc->encryptX($input, $salt);
        return array("salt" => $salt, "hash" => $val);
    }
    public function checkEncrypt($hash, $input, $salt)
    {
        $enc = new PasswordEncryptor_Blowfish();
        return $enc->check($hash, $input, $salt);
    }
    public static function login($data)
    {
        $email = $data["email"];
        $password = $data["password"];
        $hashPassword="";
        $salt = "";
        $user = User::get()->filter([
            'email' => $email,
        ])->first();
        if(!is_null($user)){
            $hashPassword = $user->Password;
            $salt = $user->Salt;
        }

        $res = (new self)->checkEncrypt($hashPassword, $password, $salt);

        return $res;
    }
    public function register($data)
    {
        $email = $data["email"];
        $password = $data["password"];
        $hashPassword="";
        $salt = "";
        $user = UserData::get()->filter([
            'email' => $email,
        ])->first();
        if(!is_null($user)){
            return(array("info"=>"failed","message"=>"email already taken"));
        }else{
            $enc = $this->encrypt($data["password"]);
            $newUser =  UserData::Create();
            $newUser->nama = $data["name"];
            $newUser->email = $data["email"];
            $newUser->password = $enc["hash"];
            $newUser->salt = $enc["salt"];
            $newUser->write();
           return(array("info"=>"success","message"=>"Account successfully created"));
        }
    }
    public function logout($data)
    {
        $key = $data["key"];
        $token = $data["token"];
        $payload= $this->checkUser($token,$key);
        // var_dump($payload);
        // die;
        $user = UserData::get()->filter([
            'email' => $payload["data"]->email,
        ])->first();
        if(!is_null($user)){
            $user->is_login = 0;
            $user->exp_time = "";
            $user->last_device_id = "";
            $user->write();
            return(array("info"=>"success","message"=>"logout success"));
        }else{
           return(array("info"=>"failed","message"=>"Account not found"));
        }
    }
}
