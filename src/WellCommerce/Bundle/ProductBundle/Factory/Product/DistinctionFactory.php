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

namespace WellCommerce\Bundle\ProductBundle\Factory\Product;

use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\ProductBundle\Entity\Product\Distinction;
use WellCommerce\Bundle\ProductBundle\Entity\Product\DistinctionInterface;

/**
 * Class DistinctionFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DistinctionFactory extends AbstractEntityFactory
{
    public function create() : DistinctionInterface
    {
        $distinction = new Distinction();
        
        return $distinction;
    }
}
