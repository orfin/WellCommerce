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

namespace WellCommerce\Bundle\PaymentBundle\Entity;

/**
 * Class PaymentMethodTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait PaymentMethodTrait
{
    /**
     * @var PaymentMethodInterface
     *
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethod")
     * @ORM\JoinColumn(name="payment_method_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    protected $paymentMethod;

    /**
     * @return PaymentMethodInterface
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @param PaymentMethodInterface $paymentMethod
     */
    public function setPaymentMethod(PaymentMethodInterface $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }
}
