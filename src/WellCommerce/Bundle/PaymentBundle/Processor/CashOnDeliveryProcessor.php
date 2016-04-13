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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;

/**
 * Class CashOnDeliveryProcessor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CashOnDeliveryProcessor extends AbstractPaymentProcessor
{
    const PROCESSOR_NAME = 'cash_on_delivery';

    /**
     * {@inheritdoc}
     */
    public function getInitializeUrl() : string
    {
        return $this->getRouterHelper()->redirectTo('front.payment.cash_on_delivery.initialize');
    }
}
