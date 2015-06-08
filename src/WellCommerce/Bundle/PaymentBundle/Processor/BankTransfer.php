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

namespace WellCommerce\Bundle\PaymentBundle\Processor;

/**
 * Class BankTransfer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class BankTransfer extends AbstractPaymentProcessor
{
    protected $name  = 'Bank transfer';
    protected $alias = 'bank_transfer';

    public function getName()
    {
        return $this->name;
    }
}
