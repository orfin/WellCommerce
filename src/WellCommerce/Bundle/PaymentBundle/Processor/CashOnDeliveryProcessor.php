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

/**
 * Class CashOnDeliveryProcessor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CashOnDeliveryProcessor extends AbstractPaymentProcessor
{
    /**
     * {@inheritdoc}
     */
    public function getInitializeUrl() : string
    {
        return $this->getRouterHelper()->generateUrl('front.cash_on_delivery.initialize');
    }
}
