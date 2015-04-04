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
namespace WellCommerce\Bundle\SmugglerBundle\Form;

use WellCommerce\Bundle\FormBundle\Builder\AbstractFormBuilder;
use WellCommerce\Bundle\FormBundle\Builder\FormBuilderInterface;
use WellCommerce\Bundle\FormBundle\DataTransformer\TranslationTransformer;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;

/**
 * Class PackageFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class PackageFormBuilder extends AbstractFormBuilder implements FormBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $unitForm)
    {
        $unitRequiredData = $unitForm->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('form.required_data.label')
        ]));

        $unitTranslationData = $unitRequiredData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('form.translations.label'),
            'transformer' => new TranslationTransformer($this->get('product.repository'))
        ]));

        $unitTranslationData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('unit.name.label'),
        ]));

        $unitForm->addFilter($this->getFilter('no_code'));
        $unitForm->addFilter($this->getFilter('trim'));
        $unitForm->addFilter($this->getFilter('secure'));
    }
}
