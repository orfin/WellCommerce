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

namespace WellCommerce\Bundle\ShippingBundle\Adapter;

use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;

/**
 * Class ProductAdapter
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductAdapter implements ShippingCalculatorAdapterInterface
{
    public function getQuantity() : int
    {
        // TODO: Implement getQuantity() method.
    }
    
    public function getWeight() : float
    {
        // TODO: Implement getWeight() method.
    }
    
    public function getGrossPrice() : float
    {
        // TODO: Implement getGrossPrice() method.
    }
    
    public function getCurrency() : string
    {
        // TODO: Implement getCurrency() method.
    }
    
    public function supports($resource) : bool
    {
        return $resource instanceof ProductInterface;
    }
}
