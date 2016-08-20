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

namespace WellCommerce\Bundle\ProductBundle\Factory;

use WellCommerce\Bundle\CoreBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\ProductBundle\Entity\ProductDistinction;
use WellCommerce\Bundle\ProductBundle\Entity\ProductDistinctionInterface;

/**
 * Class ProductDistinctionFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductDistinctionFactory extends AbstractEntityFactory
{
    public function create() : ProductDistinctionInterface
    {
        $distinction = new ProductDistinction();
        
        return $distinction;
    }
}
