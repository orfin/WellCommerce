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
namespace WellCommerce\CommonBundle\Form\Admin;

use WellCommerce\AppBundle\Form\AbstractFormBuilder;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class CompanyFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $requiredData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('common.fieldset.general')
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('company.label.name'),
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'  => 'shortName',
            'label' => $this->trans('company.label.short_name'),
        ]));

        $addressData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'address_data',
            'label' => $this->trans('address.label.addresses')
        ]));

        $addressData->addChild($this->getElement('text_field', [
            'name'  => 'street',
            'label' => $this->trans('address.label.street'),
        ]));

        $addressData->addChild($this->getElement('text_field', [
            'name'  => 'streetNo',
            'label' => $this->trans('address.label.street_no'),
        ]));

        $addressData->addChild($this->getElement('text_field', [
            'name'  => 'flatNo',
            'label' => $this->trans('address.label.flat_no'),
        ]));

        $addressData->addChild($this->getElement('text_field', [
            'name'  => 'province',
            'label' => $this->trans('address.label.province'),
        ]));

        $addressData->addChild($this->getElement('text_field', [
            'name'  => 'postCode',
            'label' => $this->trans('address.label.post_code'),
        ]));

        $addressData->addChild($this->getElement('text_field', [
            'name'  => 'city',
            'label' => $this->trans('address.label.city'),
        ]));

        $addressData->addChild($this->getElement('select', [
            'name'    => 'country',
            'label'   => $this->trans('address.label.country'),
            'options' => $this->get('country.repository')->all()
        ]));

        $mediaData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'media_data',
            'label' => $this->trans('common.fieldset.photos')
        ]));

        $mediaData->addChild($this->getElement('image', [
            'name'         => 'photo',
            'label'        => $this->trans('company.label.logo'),
            'load_route'   => $this->getRouterHelper()->generateUrl('admin.media.grid'),
            'upload_url'   => $this->getRouterHelper()->generateUrl('admin.media.add'),
            'repeat_min'   => 0,
            'repeat_max'   => 1,
            'transformer'  => $this->getRepositoryTransformer('entity', $this->get('media.repository')),
            'session_id'   => $this->getRequestHelper()->getSessionId(),
            'session_name' => $this->getRequestHelper()->getSessionName(),
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
