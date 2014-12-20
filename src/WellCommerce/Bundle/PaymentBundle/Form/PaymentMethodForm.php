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
namespace WellCommerce\Bundle\PaymentBundle\Form;

use WellCommerce\Bundle\CoreBundle\Form\AbstractForm;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\CollectionToArrayTransformer;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;

/**
 * Class PaymentMethodForm
 *
 * @package WellCommerce\Bundle\PaymentBundle\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form = $builder->init($options);

        $requiredData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('Required data')
        ]));

        $languageData = $requiredData->addChild($builder->getElement('fieldset_language', [
            'name'  => 'translations',
            'label' => $this->trans('Translations')
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('Name'),
            'rules' => [
                $builder->getRule('required', [
                    'message' => $this->trans('Name is required')
                ]),
            ]
        ]));

        $requiredData->addChild($builder->getElement('select', [
            'name'    => 'processor',
            'label'   => $this->trans('Processor'),
            'options' => [],
        ]));

        $requiredData->addChild($builder->getElement('checkbox', [
            'name'    => 'enabled',
            'label'   => $this->trans('Enabled'),
            'default' => 1
        ]));

        $requiredData->addChild($builder->getElement('text_field', [
            'name'    => 'hierarchy',
            'label'   => $this->trans('Hierarchy'),
            'rules'   => [
                $builder->getRule('required', [
                    'message' => $this->trans('Hierarchy is required')
                ])
            ],
            'default' => 0
        ]));

        $form->addFilter('no_code');
        $form->addFilter('trim');
        $form->addFilter('secure');

        return $form;
    }
}
