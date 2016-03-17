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

namespace WellCommerce\Bundle\ProductStatusBundle\Context\Front;

use WellCommerce\Bundle\ProductStatusBundle\Entity\ProductStatusInterface;

/**
 * Interface ProductStatusContextInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProductStatusContextInterface
{
    /**
     * @param ProductStatusInterface $productStatus
     */
    public function setCurrentProductStatus(ProductStatusInterface $productStatus);

    /**
     * @return ProductStatusInterface
     */
    public function getCurrentProductStatus() : ProductStatusInterface;

    /**
     * @return int
     */
    public function getCurrentProductStatusIdentifier() : int;

    /**
     * @return bool
     */
    public function hasCurrentProductStatus() : bool;
}
