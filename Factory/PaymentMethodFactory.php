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
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodInterface;

/**
 * Class PaymentMethodFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodFactory extends AbstractFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = PaymentMethodInterface::class;

    /**
     * @return PaymentMethodInterface
     */
    public function create()
    {
        /** @var  $paymentMethod PaymentMethodInterface */
        $paymentMethod = $this->init();
        $paymentMethod->setHierarchy(0);
        $paymentMethod->setEnabled(true);
        $paymentMethod->setConfiguration(new ArrayCollection());
        $paymentMethod->setShippingMethods(new ArrayCollection());

        return $paymentMethod;
    }
}
