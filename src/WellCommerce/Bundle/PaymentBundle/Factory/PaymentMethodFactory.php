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

use WellCommerce\Bundle\CoreBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethod;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodInterface;

/**
 * Class PaymentMethodFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodFactory extends AbstractEntityFactory
{
    public function create() : PaymentMethodInterface
    {
        $paymentMethod = new PaymentMethod();
        $paymentMethod->setHierarchy(0);
        $paymentMethod->setEnabled(true);
        $paymentMethod->setConfiguration([]);
        $paymentMethod->setShippingMethods($this->createEmptyCollection());
        $paymentMethod->setProcessor('');
        
        return $paymentMethod;
    }
}
