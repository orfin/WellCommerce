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

use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\ProductBundle\Entity\VariantOptionInterface;

/**
 * Class VariantFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class VariantOptionFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = VariantOptionInterface::class;

    /**
     * @return VariantOptionInterface
     */
    public function create() : VariantOptionInterface
    {
        /** @var  $variantOption VariantOptionInterface */
        $variantOption = $this->init();

        return $variantOption;
    }
}
