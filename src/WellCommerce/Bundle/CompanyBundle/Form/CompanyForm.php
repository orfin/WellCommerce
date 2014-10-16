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
namespace WellCommerce\Bundle\CompanyBundle\Form;

use WellCommerce\Bundle\FormBundle\Form\AbstractForm;
use WellCommerce\Bundle\FormBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\FormBundle\Form\FormInterface;
use WellCommerce\Bundle\MediaBundle\Form\DataTransformer\MediaEntityToIdentifierTransformer;

/**
 * Class CompanyForm
 *
 * @package WellCommerce\Company\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form = $builder->init($options);

        $requiredData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('form.required_data')
        ]));

        $requiredData->addChild($builder->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('company.name'),
//            'rules' => [
//                $builder->getRule('required', [
//                    'message' => $this->trans('Name is required')
//                ])
//            ]
        ]));

        $requiredData->addChild($builder->getElement('text_field', [
            'name'  => 'shortName',
            'label' => $this->trans('company.short_name'),
            'rules' => [
                $builder->getRule('required', [
                    'message' => $this->trans('Short name is required')
                ])
            ]
        ]));

        $addressData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'address_data',
            'label' => $this->trans('Address data')
        ]));

        $addressData->addChild($builder->getElement('text_field', [
            'name'  => 'street',
            'label' => $this->trans('Street'),
        ]));

        $addressData->addChild($builder->getElement('text_field', [
            'name'  => 'streetNo',
            'label' => $this->trans('Street number'),
        ]));

        $addressData->addChild($builder->getElement('text_field', [
            'name'  => 'flatNo',
            'label' => $this->trans('Flat number'),
        ]));

        $addressData->addChild($builder->getElement('text_field', [
            'name'  => 'province',
            'label' => $this->trans('Province'),
        ]));

        $addressData->addChild($builder->getElement('text_field', [
            'name'  => 'postCode',
            'label' => $this->trans('Post code'),
        ]));

        $addressData->addChild($builder->getElement('text_field', [
            'name'  => 'city',
            'label' => $this->trans('City'),
        ]));

        $addressData->addChild($builder->getElement('select', [
            'name'    => 'country',
            'label'   => $this->trans('Country'),
            'options' => $this->get('country.repository')->all()
        ]));

        $mediaData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'media_data',
            'label' => $this->trans('fieldset.media')
        ]));

        $mediaData->addChild($builder->getElement('image', [
            'name'        => 'photo',
            'label'       => $this->trans('Company logo'),
            'load_route'  => $this->generateUrl('admin.media.grid'),
            'upload_url'  => $this->generateUrl('admin.media.add'),
            'repeat_min'  => 0,
            'repeat_max'  => 1,
            'transformer' => new MediaEntityToIdentifierTransformer($this->get('media.repository'))
        ]));

        $form->addFilter('no_code');
        $form->addFilter('trim');
        $form->addFilter('secure');

        return $form;
    }
}
