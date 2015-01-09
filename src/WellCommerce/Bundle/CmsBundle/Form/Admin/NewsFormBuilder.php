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
namespace WellCommerce\Bundle\CmsBundle\Form\Admin;

use WellCommerce\Bundle\CoreBundle\Form\Builder\AbstractFormBuilder;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\TranslationTransformer;
use WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface;

/**
 * Class NewsFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class NewsFormBuilder extends AbstractFormBuilder implements FormBuilderInterface
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

        $languageData = $requiredData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('form.translations.label'),
            'transformer' => new TranslationTransformer($this->get('news.repository'))
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'topic',
            'label' => $this->trans('news.topic.label'),
        ]));

        $languageData->addChild($this->getElement('text_area', [
            'name'  => 'summary',
            'label' => $this->trans('news.summary.label'),
        ]));

        $languageData->addChild($this->getElement('text_area', [
            'name'  => 'content',
            'label' => $this->trans('news.content.label'),
        ]));

        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
