<?php
$I = new AcceptanceTester\AdminUserSteps($scenario);
$I->login('adam@wellcommerce.org', '123');
$I->amOnPage('/admin/product/index');
$I->seeLink('Add');
$I->seeElement('#datagrid-product');
