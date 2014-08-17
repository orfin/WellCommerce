<?php
use \AcceptanceTester;

class HomePageCest
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
        $I->wantTo('Check if home page contains readme');
        $I->amOnPage('/');
        $I->see('What is WellCommerce?');
    }
}