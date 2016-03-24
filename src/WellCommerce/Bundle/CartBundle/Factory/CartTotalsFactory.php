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

use WellCommerce\Bundle\CartBundle\Entity\CartTotalsInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;

/**
 * Class CartTotalsFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartTotalsFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = CartTotalsInterface::class;

    /**
     * @return CartTotalsInterface
     */
    public function create() : CartTotalsInterface
    {
        /** @var $totals CartTotalsInterface */
        $totals = $this->init();
        $totals->setQuantity(0);
        $totals->setGrossPrice(0);
        $totals->setNetPrice(0);
        $totals->setTaxAmount(0);
        $totals->setWeight(0);

        return $totals;
    }
}
