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

namespace WellCommerce\Bundle\ShippingBundle\Calculator;

use WellCommerce\Bundle\FormBundle\FormBuilderInterface;
use WellCommerce\Bundle\FormBundle\Dependencies\DependencyInterface;
use WellCommerce\Bundle\FormBundle\Elements\Fieldset\FieldsetInterface;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;

/**
 * Class FixedPriceCalculator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FixedPriceCalculator extends AbstractShippingMethodCalculator implements ShippingMethodCalculatorInterface
{
    /**
     * @var string
     */
    protected $alias = 'fixed_price';

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Fixed price';
    }

    /**
     * {@inheritdoc}
     */
    public function calculate()
    {
        $cart   = $this->cartProvider->getCurrentCart();
        $totals = $cart->getTotals();

        return $totals->getQuantity() * 11;
    }
}
