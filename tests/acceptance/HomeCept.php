<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('Check if home page triggers error');
$I->amOnPage('/');
$I->see('No route found for');
