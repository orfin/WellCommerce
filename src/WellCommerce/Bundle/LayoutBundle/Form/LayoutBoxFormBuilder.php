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
namespace WellCommerce\Bundle\LayoutBundle\Form;

use WellCommerce\Bundle\CoreBundle\Form\Builder\AbstractFormBuilder;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\TranslationTransformer;
use WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface;

/**
 * Class LayoutBoxFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxFormBuilder extends AbstractFormBuilder implements FormBuilderInterface
{
    const FORM_INIT_EVENT = 'layout_box.form.init';

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $requiredData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('Required data')
        ]));

        $languageData = $requiredData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('form.required_data.language_data.label'),
            'transformer' => new TranslationTransformer($this->get('layout_box.repository'))
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('Name'),
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'    => 'identifier',
            'label'   => $this->trans('layout_box.identifier.label'),
            'comment' => $this->trans('layout_box.identifier.comment'),
        ]));

        $requiredData->addChild($this->getElement('select', [
            'name'  => 'boxType',
            'label' => $this->trans('layout_box.box_type.label'),
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
