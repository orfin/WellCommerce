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

namespace WellCommerce\Bundle\ShippingBundle\Provider;

use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;

/**
 * Interface ProductShippingMethodProviderInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProductShippingMethodProviderInterface extends ShippingMethodProviderInterface
{
    /**
     * @param ProductInterface $product
     *
     * @return mixed
     */
    public function getShippingMethodOptions(ProductInterface $product);
}
