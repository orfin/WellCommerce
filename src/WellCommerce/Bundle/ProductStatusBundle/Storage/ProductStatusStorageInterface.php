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

namespace WellCommerce\Bundle\ProductStatusBundle\Storage;

use WellCommerce\Bundle\ProductStatusBundle\Entity\ProductStatusInterface;

/**
 * Interface ProductStatusStorageInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProductStatusStorageInterface
{
    public function setCurrentProductStatus(ProductStatusInterface $productStatus);

    public function getCurrentProductStatus() : ProductStatusInterface;

    public function getCurrentProductStatusIdentifier() : int;

    public function hasCurrentProductStatus() : bool;
}
