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

namespace WellCommerce\ShippingMethod\Calculator;

use WellCommerce\Core\Form\Builder\FormBuilderInterface;

/**
 * Class CartTotalTableCalculator
 *
 * @package WellCommerce\ShippingMethod\Calculator
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartTotalTableCalculator extends AbstractShippingMethodCalculator implements ShippingMethodCalculatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->trans('Cart total table');
    }

    /**
     * {@inheritdoc}
     */
    public function calculate()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function addConfigurationFields()
    {
        $this->fieldset->addChild($this->builder->addRangeEditor([
            'name'            => 'costs',
            'label'           => $this->trans('Cart total ranges'),
            'allow_vat'       => true,
        ]));

    }

}