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

use WellCommerce\Bundle\CoreBundle\Collection\AbstractCollection;

/**
 * Class PaymentMethodProcessorCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodProcessorCollection extends AbstractCollection
{
    /**
     * {@inheritdoc}
     */
    public function add(PaymentMethodProcessorInterface $processor)
    {
        $this->items[$processor->getAlias()] = $processor;
    }
}
