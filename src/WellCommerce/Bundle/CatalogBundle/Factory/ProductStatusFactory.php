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

namespace WellCommerce\Bundle\CatalogBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\CatalogBundle\Entity\ProductStatus;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;

/**
 * Class ProductStatusFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\Bundle\CatalogBundle\Entity\ProductStatusInterface
     */
    public function create()
    {
        $productStatus = new ProductStatus();
        $productStatus->setProducts(new ArrayCollection());

        return $productStatus;
    }
}
