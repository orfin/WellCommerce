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

namespace WellCommerce\Bundle\CartBundle\Calculator;

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;

/**
 * Class CartTotalsCalculator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartTotalsCalculator implements CartTotalsCalculatorInterface
{
    /**
     * @var CartTotalsVisitorCollection
     */
    protected $visitorCollection;

    /**
     * Constructor
     *
     * @param CartTotalsVisitorCollection $visitorCollection
     */
    public function __construct(CartTotalsVisitorCollection $visitorCollection)
    {
        $this->visitorCollection = $visitorCollection;
    }

    /**
     * {@inheritdoc}
     */
    public function calculate(CartInterface $cart)
    {
        foreach ($this->visitorCollection->all() as $visitor) {
            $visitor->visitCart($cart);
        }
    }
}
