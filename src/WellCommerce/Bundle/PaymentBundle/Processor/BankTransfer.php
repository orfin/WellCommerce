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

use WellCommerce\Bundle\FormBundle\Elements\ElementInterface;
use WellCommerce\Bundle\FormBundle\FormBuilderInterface;

/**
 * Class BankTransfer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class BankTransfer extends AbstractPaymentProcessor
{
    protected $name  = 'Bank transfer';
    protected $alias = 'bank_transfer';

    /**
     * {@inheritdoc}
     */
    public function addConfigurationFields(FormBuilderInterface $builder, ElementInterface $fieldset)
    {
        $fieldset->addChild($builder->getElement('text_field', [
            'name'  => 'account',
            'label' => $this->trans('payment_method.bank_transfer.account'),
        ]))->setValue(111);
    }
}
