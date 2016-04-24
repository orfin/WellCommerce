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

namespace WellCommerce\Bundle\CartBundle\Factory;

use WellCommerce\Bundle\CartBundle\Entity\CartProductTotalInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;

/**
 * Class CartProductTotalFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class CartProductTotalFactory extends AbstractEntityFactory
{
    protected $supportsInterface = CartProductTotalInterface::class;

    public function create() : CartProductTotalInterface
    {
        return $this->init();
    }
}
