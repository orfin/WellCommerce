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
 * Class ProductShippingMethodProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductShippingMethodProvider extends AbstractShippingMethodProvider implements ProductShippingMethodProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getShippingMethodOptions(ProductInterface $product)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function supports($class)
    {
        return ($class instanceof ProductInterface);
    }
}
