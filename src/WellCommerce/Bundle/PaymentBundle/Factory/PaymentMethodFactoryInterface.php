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

use WellCommerce\Bundle\CoreBundle\Factory\FactoryInterface;

/**
 * Interface PaymentMethodFactoryInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PaymentMethodFactoryInterface extends FactoryInterface
{
    /**
     * @return \WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodInterface
     */
    public function create();
}
