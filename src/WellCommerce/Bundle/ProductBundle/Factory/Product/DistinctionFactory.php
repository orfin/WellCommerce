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

use WellCommerce\Bundle\DoctrineBundle\Factory\EntityFactory;
use WellCommerce\Bundle\ProductBundle\Entity\Product\DistinctionInterface;

/**
 * Class DistinctionFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DistinctionFactory extends EntityFactory
{
    public function create() : DistinctionInterface
    {
        return $this->init();
    }
}
