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

use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodInterface;

/**
 * Class WeightTableCalculator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class WeightTableCalculator extends AbstractShippingMethodCalculator
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Weight table';
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'weight_table';
    }

    /**
     * {@inheritdoc}
     */
    public function calculate(ShippingMethodInterface $shippingMethod, ShippingCalculatorSubjectInterface $subject)
    {
        return null;
    }
}
