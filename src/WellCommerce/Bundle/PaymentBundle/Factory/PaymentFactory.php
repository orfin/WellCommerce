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

/**
 * Class PaymentFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = PaymentInterface::class;

    /**
     * @return PaymentInterface
     */
    public function create() : PaymentInterface
    {
        /** @var  $payment PaymentInterface */
        $payment = $this->init();
        $payment->setState(PaymentInterface::PAYMENT_STATE_CREATED);
        $payment->setConfiguration([]);
        $payment->setApprovalUrl('');
        $payment->setToken('');

        return $payment;
    }
}
