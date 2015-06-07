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
namespace WellCommerce\Bundle\OrderBundle\Form;

use WellCommerce\Bundle\DataSetBundle\CollectionBuilder\SelectBuilder;
use WellCommerce\Bundle\FormBundle\Builder\AbstractFormBuilder;
use WellCommerce\Bundle\FormBundle\Builder\FormBuilderInterface;
use WellCommerce\Bundle\FormBundle\DataTransformer\EntityToIdentifierTransformer;
use WellCommerce\Bundle\FormBundle\DataTransformer\TranslationTransformer;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;

/**
 * Class OrderStatusFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderStatusFormBuilder extends AbstractFormBuilder implements FormBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $requiredData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('form.required_data.label')
        ]));

        $requiredData->addChild($this->getElement('checkbox', [
            'name'    => 'enabled',
            'label'   => $this->trans('order_status.enabled.label'),
            'comment' => $this->trans('order_status.enabled.comment'),
            'default' => 1
        ]));

        $orderStatusGroupSelectBuilder = new SelectBuilder($this->get('order_status_group.dataset'));
        $orderStatusGroups             = $orderStatusGroupSelectBuilder->getItems();

        $requiredData->addChild($this->getElement('select', [
            'name'        => 'orderStatusGroup',
            'label'       => $this->trans('order_status.order_status_group.label'),
            'options'     => $orderStatusGroups,
            'default'     => current(array_keys($orderStatusGroups)),
            'transformer' => new EntityToIdentifierTransformer($this->get('order_status_group.repository'))
        ]));

        $languageData = $requiredData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('fieldset.translations.label'),
            'transformer' => new TranslationTransformer($this->get('order_status.repository'))
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('order_status.name.label'),
        ]));

        $languageData->addChild($this->getElement('rich_text_editor', [
            'name'  => 'defaultComment',
            'label' => $this->trans('order_status.default_comment.label')
        ]));

        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
