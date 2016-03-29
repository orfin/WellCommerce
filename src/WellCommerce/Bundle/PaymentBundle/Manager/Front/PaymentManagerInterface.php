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

namespace WellCommerce\Bundle\PaymentBundle\Manager\Front;

use WellCommerce\Bundle\CoreBundle\Manager\Front\FrontManagerInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;
use WellCommerce\Bundle\PaymentBundle\Processor\PaymentMethodProcessorInterface;

/**
 * Interface PaymentManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PaymentManagerInterface extends FrontManagerInterface
{
    /**
     * Finds order by its id or throws an exception
     *
     * @return OrderInterface
     * @throws \WellCommerce\Bundle\OrderBundle\Exception\OrderNotFoundException
     */
    public function findOrder() : OrderInterface;

    /**
     * Creates a payment object if none was found
     *
     * @param OrderInterface $order
     *
     * @return PaymentInterface
     */
    public function createPayment(OrderInterface $order, PaymentMethodProcessorInterface $processor) : PaymentInterface;
    
    /**
     * Returns a payment object for given processor and token
     *
     * @param string $processor
     * @param string $token
     *
     * @return PaymentInterface
     */
    public function findProcessorPaymentByToken(string $processor, string $token) : PaymentInterface;
}
