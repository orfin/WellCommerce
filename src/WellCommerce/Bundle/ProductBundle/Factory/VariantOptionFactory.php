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
use WellCommerce\Bundle\ProductBundle\Entity\VariantOption;
use WellCommerce\Bundle\ProductBundle\Entity\VariantOptionInterface;

/**
 * Class VariantOptionFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class VariantOptionFactory extends AbstractEntityFactory
{
    public function create() : VariantOptionInterface
    {
        $option = new VariantOption();

        return $option;
    }
}
