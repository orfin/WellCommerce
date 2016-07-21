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

namespace WellCommerce\Bundle\PaymentBundle\Factory;

use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentStateHistory;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentStateHistoryInterface;

/**
 * Class PaymentStateHistoryFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentStateHistoryFactory extends AbstractEntityFactory
{
    public function create() : PaymentStateHistoryInterface
    {
        $paymentStateHistory = new PaymentStateHistory();
        $paymentStateHistory->setState(PaymentInterface::PAYMENT_STATE_CREATED);
        $paymentStateHistory->setComment('');

        return $paymentStateHistory;
    }
}
