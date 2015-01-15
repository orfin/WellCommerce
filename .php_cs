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

use Symfony\CS\FixerInterface;

$finder = Symfony\CS\Finder\DefaultFinder::create();
$finder->notName('*.yml');
$finder->notName('*.xml');
$finder->notName('*Spec.php');
$finder->exclude('app');

return Symfony\CS\Config\Config::create()->finder($finder);