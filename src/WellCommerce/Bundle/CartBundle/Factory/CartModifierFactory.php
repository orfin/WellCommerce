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

use WellCommerce\Bundle\CartBundle\Entity\CartModifierInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;

/**
 * Class CartModifierFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class CartModifierFactory extends AbstractEntityFactory
{
    protected $supportsInterface = CartModifierInterface::class;

    public function create() : CartModifierInterface
    {
        /** @var $modifier CartModifierInterface */
        $modifier = $this->init();
        $modifier->setGrossAmount(0);
        $modifier->setNetAmount(0);
        $modifier->setTaxAmount(0);

        return $modifier;
    }
}
