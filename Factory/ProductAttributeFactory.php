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

use WellCommerce\Bundle\AppBundle\Entity\DiscountablePrice;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAttributeInterface;

/**
 * Class ProductAttributeFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductAttributeFactory extends AbstractFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = ProductAttributeInterface::class;

    /**
     * @return ProductAttributeInterface
     */
    public function create()
    {
        /** @var  $productAttribute ProductAttributeInterface */
        $productAttribute = $this->init();
        $productAttribute->setHierarchy(0);
        $productAttribute->setModifierType('%');
        $productAttribute->setModifierValue(100);
        $productAttribute->setSellPrice(new DiscountablePrice());
        $productAttribute->setAvailability(null);

        return $productAttribute;
    }
}
