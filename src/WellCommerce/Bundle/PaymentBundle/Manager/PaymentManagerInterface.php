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

use WellCommerce\Bundle\CoreBundle\Manager\Front\FrontManagerInterface;
use WellCommerce\Bundle\CoreBundle\Manager\ManagerInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;
use WellCommerce\Bundle\PaymentBundle\Processor\PaymentProcessorInterface;

/**
 * Interface PaymentManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PaymentManagerInterface extends ManagerInterface
{
    /**
     * Returns the first payment for order or creates a new one
     *
     * @param OrderInterface            $order
     *
     * @return PaymentInterface
     */
    public function createFirstPaymentForOrder(OrderInterface $order) : PaymentInterface;

    /**
     * Returns the processor object for given name
     *
     * @param string $name
     *
     * @return PaymentProcessorInterface
     */
    public function getPaymentProcessor(string $name) : PaymentProcessorInterface;
}
