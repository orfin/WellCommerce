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

use WellCommerce\Component\Form\Dependencies\DependencyInterface;
use WellCommerce\Component\Form\Elements\ElementInterface;
use WellCommerce\Component\Form\FormBuilderInterface;

/**
 * Class BankTransfer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class BankTransfer extends AbstractPaymentProcessor
{
    /**
     * @var string
     */
    protected $name  = 'Bank transfer';

    /**
     * @var string
     */
    protected $alias = 'bank_transfer';

    /**
     * {@inheritdoc}
     */
    public function addConfigurationFields(FormBuilderInterface $builder, ElementInterface $fieldset, DependencyInterface $dependency)
    {
        $fieldset->addChild($builder->getElement('text_field', [
            'name'         => $this->getFieldName('account'),
            'label'        => $this->trans('payment_method.bank_transfer.account'),
            'dependencies' => [$dependency]
        ]));

        $fieldset->addChild($builder->getElement('text_field', [
            'name'         => $this->getFieldName('sort_number'),
            'label'        => $this->trans('payment_method.bank_transfer.sort_number'),
            'dependencies' => [$dependency]
        ]));
    }
}
