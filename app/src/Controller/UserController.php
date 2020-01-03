<?php

use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\Security\Member;

class UserController extends ContentController
{
    private static $allowed_actions = ['login', 'dologin', 'dologout', 'forgotpassword', 'test'];

    public function init() {
        parent::init();
        @session_start();
    }

    public function index()
    {
        if (!self::cekSession())
            return $this->redirect(Director::absoluteBaseURL()."user/login");
        else
            return $this->redirect(Director::absoluteBaseURL());
    }

    public function test()
    {
        $email = AddOn::sendEmailSMTP('rezapahlevi056@gmail.com', 'test', array('test'), array('ForgotPassword'));

        echo json_encode($email);
    }

    public function forgotpassword() {
        if (self::cekSession())
            return $this->redirect(Director::absoluteBaseURL());

            $arr_data = array(
                'Results' => "Zemmy",
                'Error' => @$_SESSION['error_login']
            );
            return $this->customise($arr_data)
                ->renderWith(array(
                    'ForgotPassword'
                ));
    }

    public function login() {
        if (self::cekSession())
            return $this->redirect(Director::absoluteBaseURL());

        $arr_data = array(
            'Results' => "Zemmy",
            'Error' => @$_SESSION['error_login']
        );
        return $this->customise($arr_data)
            ->renderWith(array(
                'Login'
            ));
    }

    public function dologin() {
        $status = Auth::login($_POST);
        if ($status) {
            $user = Member::get()->where("`Email` = '{$_POST['email']}'")->first();
            // var_dump($user);die;
            // var_dump($user);
            // die;
            @session_unset('error_login');
            // $_SESSION['user_nama'] = $user->Nama;
            $_SESSION['user_id'] = $user->UserID;
            $_SESSION['user_email'] = $user->Email;
            return $this->redirect(Director::absoluteBaseURL()."ta/");
        }
        $_SESSION['error_login'] = "1";
        return $this->redirect(Director::absoluteBaseURL()."user/login");
    }

    public function dologout() {
        session_destroy();
        return $this->redirect(Director::absoluteBaseURL()."user/login");
    }

    static function cekSession() {
        if (isset($_SESSION['user_id']) || !empty($_SESSION['user_id'])) {
            return true;
        }
        return false;
    }
}
