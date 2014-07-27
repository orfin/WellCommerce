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
$I->see('Adam Piotrowski');
