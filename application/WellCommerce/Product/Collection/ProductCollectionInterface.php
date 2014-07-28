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

namespace WellCommerce\Product\Collection;

use WellCommerce\Product\Model\Product;

/**
 * Interface ProductCollectionInterface
 *
 * @package WellCommerce\Product\Collection
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProductCollectionInterface {

    public function count();

    public function has();

    public function get($id);

    public function add(Product $product);

    public function all();
} 