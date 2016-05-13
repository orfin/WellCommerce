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

namespace WellCommerce\Bundle\PaymentBundle\Manager;

use WellCommerce\Bundle\DoctrineBundle\Manager\ManagerInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentStateHistoryInterface;

/**
 * Interface PaymentStateHistoryManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PaymentStateHistoryManagerInterface extends ManagerInterface
{
    public function createPaymentStateHistory(PaymentInterface $payment) : PaymentStateHistoryInterface;
}
