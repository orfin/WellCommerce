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

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\ProductStatusBundle\Entity\ProductStatus;

/**
 * Class ProductStatusFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\Bundle\ProductStatusBundle\Entity\ProductStatusInterface
     */
    public function create()
    {
        $productStatus = new ProductStatus();
        $productStatus->setProducts(new ArrayCollection());

        return $productStatus;
    }
}
