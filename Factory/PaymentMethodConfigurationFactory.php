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
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodConfigurationInterface;

/**
 * Class PaymentMethodConfigurationFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodConfigurationFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = PaymentMethodConfigurationInterface::class;

    /**
     * @return PaymentMethodConfigurationInterface
     */
    public function create()
    {
        /** @var  $paymentMethodConfiguration PaymentMethodConfigurationInterface */
        $paymentMethodConfiguration = $this->init();

        return $paymentMethodConfiguration;
    }
}
