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

namespace WellCommerce\SalesBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\AppBundle\Factory\AbstractFactory;
use WellCommerce\SalesBundle\Entity\PaymentMethod;

/**
 * Class PaymentMethodFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\SalesBundle\Entity\PaymentMethodInterface
     */
    public function create()
    {
        $paymentMethod = new PaymentMethod();
        $paymentMethod->setHierarchy(0);
        $paymentMethod->setEnabled(true);
        $paymentMethod->setConfiguration(new ArrayCollection());
        $paymentMethod->setShippingMethods(new ArrayCollection());

        return $paymentMethod;
    }
}
