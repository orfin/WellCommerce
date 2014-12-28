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
namespace WellCommerce\Bundle\CmsBundle\Form;

use WellCommerce\Bundle\CoreBundle\Form\AbstractForm;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface;

/**
 * Class NewsForm
 *
 * @package WellCommerce\Bundle\CmsBundle\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class NewsForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form = $builder->init($options);

        $requiredData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('form.required_data.label')
        ]));

        $languageData = $requiredData->addChild($builder->getElement('language_fieldset', [
            'name'  => 'translations',
            'label' => $this->trans('form.translations.label')
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'topic',
            'label' => $this->trans('news.topic.label'),
        ]));

        $languageData->addChild($builder->getElement('text_area', [
            'name'  => 'summary',
            'label' => $this->trans('news.summary.label'),
        ]));

        $languageData->addChild($builder->getElement('text_area', [
            'name'  => 'content',
            'label' => $this->trans('news.content.label'),
        ]));

        $form->addFilter($builder->getFilter('trim'));
        $form->addFilter($builder->getFilter('secure'));

        return $form;
    }
}
