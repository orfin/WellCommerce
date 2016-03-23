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
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\ProductBundle\Entity\VariantInterface;

/**
 * Class VariantFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class VariantFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = VariantInterface::class;

    /**
     * @return VariantInterface
     */
    public function create() : VariantInterface
    {
        /** @var  $variant VariantInterface */
        $variant = $this->init();
        $variant->setHierarchy(0);
        $variant->setModifierType('%');
        $variant->setModifierValue(100);
        $variant->setSellPrice(new DiscountablePrice());
        $variant->setAvailability(null);

        return $variant;
    }
}
