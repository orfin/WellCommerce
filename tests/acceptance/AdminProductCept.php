<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

$I = new AcceptanceTester\AdminUserSteps($scenario);
$I->login('adam@wellcommerce.org', '123');
$I->amOnPage(\AdminProductPage::$URL);
$I->seeLink('Add');
$I->seeElement('#datagrid-product');
$I->click('Delete');
$I->waitForElement('.GMessageBar', 1);