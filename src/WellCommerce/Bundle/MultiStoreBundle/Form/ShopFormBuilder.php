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
            'label' => $this->trans('shop.name.label'),
        ]));

        $requiredData->addChild($this->getElement('select', [
            'name'        => 'company',
            'label'       => $this->trans('shop.company.label'),
            'options'     => $this->get('company.collection')->getSelect(),
            'transformer' => new EntityToIdentifierTransformer($this->get('company.repository'))
        ]));

        $requiredData->addChild($this->getElement('select', [
            'name'        => 'theme',
            'label'       => $this->trans('shop.theme.label'),
            'options'     => $this->get('theme.collection')->getSelect(),
            'transformer' => new EntityToIdentifierTransformer($this->get('theme.repository'))
        ]));

        $urlData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'url_data',
            'label' => $this->trans('shop.fieldset.url_data')
        ]));

        $urlData->addChild($this->getElement('text_field', [
            'name'  => 'url',
            'label' => $this->trans('shop.url.label'),
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
