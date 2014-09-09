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

use WellCommerce\Bundle\CoreBundle\Form\AbstractForm;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\EntityToIdentifierTransformer;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;

/**
 * Class ClientForm
 *
 * @package WellCommerce\Bundle\ClientBundle\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientForm extends AbstractForm implements FormInterface
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
            'name'  => 'firstName',
            'label' => $this->trans('First name'),
            'rules' => [
                $builder->getRule('required', [
                    'message' => $this->trans('First name is required')
                ]),
            ]
        ]));

        $requiredData->addChild($builder->getElement('text_field', [
            'name'  => 'lastName',
            'label' => $this->trans('Last name'),
            'rules' => [
                $builder->getRule('required', [
                    'message' => $this->trans('Last name is required')
                ]),
            ]
        ]));

        $requiredData->addChild($builder->getElement('text_field', [
            'name'  => 'username',
            'label' => $this->trans('Username'),
            'rules' => [
                $builder->getRule('required', [
                    'message' => $this->trans('E-mail is required')
                ]),
            ]
        ]));

        $requiredData->addChild($builder->getElement('text_field', [
            'name'  => 'email',
            'label' => $this->trans('E-mail'),
            'rules' => [
                $builder->getRule('required', [
                    'message' => $this->trans('E-mail is required')
                ]),
            ]
        ]));

        $requiredData->addChild($builder->getElement('password', [
            'name'  => 'password',
            'label' => $this->trans('Password'),
            'rules' => [
                $builder->getRule('required', [
                    'message' => $this->trans('Password is required')
                ]),
            ]
        ]));

        $requiredData->addChild($builder->getElement('text_field', [
            'name'  => 'phone',
            'label' => $this->trans('Phone'),
            'rules' => [
                $builder->getRule('required', [
                    'message' => $this->trans('Phone is required')
                ]),
            ]
        ]));


        $requiredData->addChild($builder->getElement('select', [
            'name'        => 'group',
            'label'       => $this->trans('Group'),
            'options'     => $this->get('client_group.repository')->getCollectionToSelect(),
            'transformer' => new EntityToIdentifierTransformer($this->get('client_group.repository'))
        ]));

        $requiredData->addChild($builder->getElement('text_field', [
            'name'    => 'discount',
            'label'   => $this->trans('Discount'),
            'suffix'  => '%',
            'filters' => [
                $builder->getFilter('comma_to_dot_changer')
            ],
        ]));

        $form->addFilter('no_code');
        $form->addFilter('trim');
        $form->addFilter('secure');

        return $form;
    }
}
