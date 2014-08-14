<?php

class AdminCompanyCest
{
    public function _before()
    {
    }

    public function _after()
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        $I->wantTo('Check if company module is working');
        $I->amOnPage('/admin/configuration/company/index');
        $I->see('Companies');
    }
}