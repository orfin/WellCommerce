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

namespace WellCommerce\Bundle\PaymentBundle\Processor;

use WellCommerce\Component\Collections\ArrayCollection;

/**
 * Class PaymentProcessorCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentProcessorCollection extends ArrayCollection
{
    public function add(PaymentProcessorInterface $processor)
    {
        $this->items[$processor->getConfigurator()->getName()] = $processor;
    }

    /**
     * @return PaymentProcessorInterface[]
     */
    public function all()
    {
        return $this->items;
    }
}
