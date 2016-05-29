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

namespace WellCommerce\Bundle\OrderBundle\Factory;

use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\OrderBundle\Entity\OrderModifierInterface;

/**
 * Class OrderModifierFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderModifierFactory extends AbstractEntityFactory
{
    public function create() : OrderModifierInterface
    {
        /** @var $modifier OrderModifierInterface */
        $modifier = $this->init();
        $modifier->setGrossAmount(0);
        $modifier->setNetAmount(0);
        $modifier->setTaxAmount(0);
        
        return $modifier;
    }
}
