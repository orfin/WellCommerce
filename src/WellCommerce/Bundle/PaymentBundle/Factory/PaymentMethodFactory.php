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

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\OrderBundle\Entity\OrderStatusInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodInterface;

/**
 * Class PaymentMethodFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = PaymentMethodInterface::class;

    /**
     * @return PaymentMethodInterface
     */
    public function create() : PaymentMethodInterface
    {
        $defaultOrderStatus = $this->getDefaultOrderStatus();

        /** @var  $paymentMethod PaymentMethodInterface */
        $paymentMethod = $this->init();
        $paymentMethod->setHierarchy(0);
        $paymentMethod->setEnabled(true);
        $paymentMethod->setConfiguration([]);
        $paymentMethod->setShippingMethods(new ArrayCollection());
        $paymentMethod->setProcessor($this->getDefaultProcessor());
        $paymentMethod->setPaymentPendingOrderStatus($defaultOrderStatus);
        $paymentMethod->setPaymentFailureOrderStatus($defaultOrderStatus);
        $paymentMethod->setPaymentSuccessOrderStatus($defaultOrderStatus);

        return $paymentMethod;
    }

    protected function getDefaultOrderStatus() : OrderStatusInterface
    {
        return $this->get('order_status.repository')->findOneBy([]);
    }

    protected function getDefaultProcessor() : string
    {
        $processors = $this->get('payment.processor.collection')->keys();

        return current($processors);
    }
}
