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
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$collection = new RouteCollection();

$controller = 'WellCommerce\Plugin\PaymentMethod\Controller\Admin\PaymentMethodController';

$collection->add('admin.payment_method.index', new Route('/index', array(
    '_controller' => $controller,
    '_mode'       => 'admin',
    '_action'     => 'indexAction'
)));

$collection->add('admin.payment_method.add', new Route('/add', array(
    '_controller' => $controller,
    '_mode'       => 'admin',
    '_action'     => 'addAction'
)));

$collection->add('admin.payment_method.edit', new Route('/edit/{id}', array(
    '_controller' => $controller,
    '_mode'       => 'admin',
    '_action'     => 'editAction',
    'id'         => null
)));

$collection->addPrefix('/admin/payment_method');

return $collection;
