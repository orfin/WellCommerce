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

namespace WellCommerce\Bundle\ProductStatusBundle\Factory;

use WellCommerce\Bundle\DoctrineBundle\Factory\EntityFactory;
use WellCommerce\Bundle\ProductStatusBundle\Entity\ProductStatusInterface;

/**
 * Class ProductStatusFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusFactory extends EntityFactory
{
    public function create() : ProductStatusInterface
    {
        /** @var  $status ProductStatusInterface */
        $status = $this->init();
        $status->setSymbol('');
        
        return $status;
    }
}
