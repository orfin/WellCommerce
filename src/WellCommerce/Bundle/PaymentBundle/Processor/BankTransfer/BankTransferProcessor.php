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

namespace WellCommerce\Bundle\PaymentBundle\Processor\BankTransfer;

use WellCommerce\Bundle\PaymentBundle\Processor\AbstractPaymentProcessor;

/**
 * Class BankTransferProcessor
 *
 * @package WellCommerce\Bundle\PaymentBundle\Processor\BankTransfer
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class BankTransferProcessor extends AbstractPaymentProcessor
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->trans('Bank transfer');
    }
} 