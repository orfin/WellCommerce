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
        $I->wantTo('Check if home page triggers error');
        $I->amOnPage('/');
        $I->see('No route found for');
    }
}