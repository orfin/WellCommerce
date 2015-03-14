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
namespace WellCommerce\Bundle\MultiStoreBundle\Form;

use WellCommerce\Bundle\FormBundle\Builder\AbstractFormBuilder;
use WellCommerce\Bundle\FormBundle\Builder\FormBuilderInterface;
use WellCommerce\Bundle\FormBundle\DataTransformer\EntityToIdentifierTransformer;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;
use WellCommerce\Bundle\MediaBundle\Form\DataTransformer\MediaEntityToIdentifierTransformer;

/**
 * Class CompanyFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopFormBuilder extends AbstractFormBuilder implements FormBuilderInterface
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
            'label' => $this->trans('shop.name'),
        ]));

        $requiredData->addChild($this->getElement('select', [
            'name'        => 'company',
            'label'       => $this->trans('shop.company.label'),
            'options'     => $this->get('company.collection')->getSelect(),
            'transformer' => new EntityToIdentifierTransformer($this->get('company.repository'))
        ]));

        $mediaData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'media_data',
            'label' => $this->trans('fieldset.media')
        ]));

        $mediaData->addChild($this->getElement('image', [
            'name'         => 'photo',
            'label'        => $this->trans('shop.logo.label'),
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
