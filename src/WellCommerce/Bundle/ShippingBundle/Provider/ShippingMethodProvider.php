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

namespace WellCommerce\Bundle\ShippingBundle\Provider;

use WellCommerce\Bundle\ShippingBundle\Calculator\ShippingCalculatorSubjectInterface;

/**
 * Class ShippingMethodProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingMethodProvider extends AbstractShippingMethodProvider implements ShippingMethodProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getShippingMethodCostsCollection(ShippingCalculatorSubjectInterface $subject)
    {
        if (null === $this->collection) {
            $this->collection = $this->getCollection($subject);
        }

        return $this->sortCollection();
    }
}
