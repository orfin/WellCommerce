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

use WellCommerce\Bundle\FormBundle\Builder\AbstractFormBuilder;
use WellCommerce\Bundle\FormBundle\Builder\FormBuilderInterface;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;
use WellCommerce\Bundle\MediaBundle\Form\DataTransformer\MediaEntityToIdentifierTransformer;

/**
 * Class CompanyFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyFormBuilder extends AbstractFormBuilder implements FormBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $requiredData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('form.required_data')
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('company.name'),
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'  => 'shortName',
            'label' => $this->trans('company.short_name'),
        ]));

        $addressData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'address_data',
            'label' => $this->trans('Address data')
        ]));

        $addressData->addChild($this->getElement('text_field', [
            'name'  => 'street',
            'label' => $this->trans('Street'),
        ]));

        $addressData->addChild($this->getElement('text_field', [
            'name'  => 'streetNo',
            'label' => $this->trans('Street number'),
        ]));

        $addressData->addChild($this->getElement('text_field', [
            'name'  => 'flatNo',
            'label' => $this->trans('Flat number'),
        ]));

        $addressData->addChild($this->getElement('text_field', [
            'name'  => 'province',
            'label' => $this->trans('Province'),
        ]));

        $addressData->addChild($this->getElement('text_field', [
            'name'  => 'postCode',
            'label' => $this->trans('Post code'),
        ]));

        $addressData->addChild($this->getElement('text_field', [
            'name'  => 'city',
            'label' => $this->trans('City'),
        ]));

        $addressData->addChild($this->getElement('select', [
            'name'    => 'country',
            'label'   => $this->trans('Country'),
            'options' => $this->get('country.repository')->all()
        ]));

        $mediaData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'media_data',
            'label' => $this->trans('fieldset.media')
        ]));

        $mediaData->addChild($this->getElement('image', [
            'name'         => 'photo',
            'label'        => $this->trans('Company logo'),
            'load_route'   => $this->generateUrl('admin.media.grid'),
            'upload_url'   => $this->generateUrl('admin.media.add'),
            'repeat_min'   => 0,
            'repeat_max'   => 1,
            'transformer'  => new MediaEntityToIdentifierTransformer($this->get('media.repository')),
            'session_id'   => $this->getRequest()->getSession()->getId(),
            'session_name' => $this->getRequest()->getSession()->getName(),
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
