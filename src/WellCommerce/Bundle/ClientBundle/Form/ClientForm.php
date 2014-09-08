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
namespace WellCommerce\Bundle\ClientBundle\Form;

use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;

/**
 * Class ClientForm
 *
 * @package WellCommerce\Bundle\ClientBundle\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form = $builder->init($options);

        $requiredData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('form.required_data.label')
        ]));

        $requiredData->addChild($builder->getElement('text_field', [
            'name'    => 'firstName',
            'label'   => $this->trans('First name'),
            'rules' => [
                $builder->getRule('required', [
                    'message' => $this->trans('First name is required')
                ]),
            ]
        ]));

        $requiredData->addChild($builder->getElement('text_field', [
            'name'    => 'lastName',
            'label'   => $this->trans('Last name'),
            'rules' => [
                $builder->getRule('required', [
                    'message' => $this->trans('Last name is required')
                ]),
            ]
        ]));

        $form->addFilter('no_code');
        $form->addFilter('trim');
        $form->addFilter('secure');

        return $form;
    }
}
