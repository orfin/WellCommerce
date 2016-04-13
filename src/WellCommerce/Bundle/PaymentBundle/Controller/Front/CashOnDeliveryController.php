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

namespace WellCommerce\Bundle\PaymentBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\PaymentBundle\Manager\Front\PaymentManagerInterface;
use WellCommerce\Bundle\PaymentBundle\Processor\PaymentProcessorInterface;

/**
 * Class CashOnDeliveryController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CashOnDeliveryController extends AbstractPaymentController
{
    protected function getCurrentPaymentProcessor() : PaymentProcessorInterface
    {
        return $this->manager->getPaymentProcessor('cash_on_delivery');
    }
}
