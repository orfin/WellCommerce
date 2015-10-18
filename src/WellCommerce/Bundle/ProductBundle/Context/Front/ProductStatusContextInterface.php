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

namespace WellCommerce\Bundle\ProductBundle\Context\Front;

use WellCommerce\Bundle\ProductBundle\Entity\ProductStatusInterface;

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
     * @return null|ProductStatusInterface
     */
    public function getCurrentProductStatus();

    /**
     * @return int|null
     */
    public function getCurrentProductStatusIdentifier();

    /**
     * @return bool
     */
    public function hasCurrentProductStatus();
}
