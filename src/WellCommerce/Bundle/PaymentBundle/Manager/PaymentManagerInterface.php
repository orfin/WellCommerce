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
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;

/**
 * Interface PaymentManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PaymentManagerInterface extends ManagerInterface
{
    public function createPaymentForOrder(OrderInterface $order) : PaymentInterface;

    public function findPaymentByToken(string $token) : PaymentInterface;
}
