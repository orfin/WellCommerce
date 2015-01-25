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

use WellCommerce\Bundle\CoreBundle\Form\Builder\AbstractFormBuilder;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\TranslationTransformer;
use WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface;

/**
 * Class OrderStatusGroupFormBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderStatusGroupFormBuilder extends AbstractFormBuilder implements FormBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $requiredData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('fieldset.required_data.label')
        ]));

        $languageData = $requiredData->addChild($this->getElement('language_fieldset', [
            'name'  => 'translations',
            'label' => $this->trans('fieldset.translations.label'),
            'transformer' => new TranslationTransformer($this->get('order_status_group.repository'))
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('order_status_group.name.label'),
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
