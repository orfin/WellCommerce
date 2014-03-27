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

$controller = 'WellCommerce\Plugin\Product\Controller\Frontend\ProductController';

$collection->add('frontend.product.index', new Route('/product/{slug}', [
    '_controller' => $controller,
    '_mode'       => 'frontend',
    '_action'     => 'indexAction',
    'slug'        => null
], [
    'slug' => '.+'
]));

return $collection;
