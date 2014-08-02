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

include 'bootstrap.php';

use Symfony\Component\HttpFoundation\Request;
$application = new WellCommerce\Core\Application('prod', false);
$request     = Request::createFromGlobals();
$response    = $application->handle($request);
$response->send();
$application->terminate($request, $response);

