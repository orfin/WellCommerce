<?php 
$I = new AcceptanceTester\AdminUserSteps($scenario);
$I->login('adam@wellcommerce.org', '123');
$I->see('Adam Piotrowski');
