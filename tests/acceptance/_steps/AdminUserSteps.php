<?php
namespace AcceptanceTester;

class AdminUserSteps extends \AcceptanceTester
{
    public function login($name, $password)
    {
        $I = $this;
        $I->amOnPage(\AdminLoginPage::$URL);
        $I->fillField(\AdminLoginPage::$usernameField, $name);
        $I->fillField(\AdminLoginPage::$passwordField, $password);
        $I->click(\AdminLoginPage::$loginButton);
    }
}