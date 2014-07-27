<?php

class AdminLoginPage
{
    public static $URL = '/admin/user/login';
    public static $usernameField = 'email';
    public static $passwordField = 'password';
    public static $loginButton = 'button[type=submit]';

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: EditPage::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL . $param;
    }


}