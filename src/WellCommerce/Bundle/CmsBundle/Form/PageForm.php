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

use WellCommerce\Bundle\FormBundle\Form\AbstractForm;
use WellCommerce\Bundle\FormBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\FormBundle\Form\FormInterface;

/**
 * Class PageForm
 *
 * @package WellCommerce\Bundle\CmsBundle\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PageForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form = $builder->init($options);

        $mainData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'main_data',
            'label' => $this->trans('fieldset.main.label')
        ]));

        $languageData = $mainData->addChild($builder->getElement('fieldset_language', [
            'name'  => 'translations',
            'label' => $this->trans('form.translations.label')
        ]));

        $name = $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('page.name.label'),
        ]));

        $languageData->addChild($builder->getElement('slug_field', [
            'name'            => 'slug',
            'label'           => $this->trans('page.slug.label'),
            'name_field'      => $name,
            'generate_route'  => 'admin.routing.generate',
            'translatable_id' => $this->getParam('id')
        ]));

        $mainData->addChild($builder->getElement('checkbox', [
            'name'    => 'publish',
            'label'   => $this->trans('admin.publish.label'),
            'comment' => $this->trans('admin.publish.help'),
            'default' => 1
        ]));

        $contentData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'content_data',
            'label' => $this->trans('fieldset.content.label')
        ]));

        $languageData = $contentData->addChild($builder->getElement('fieldset_language', [
            'name'  => 'translations',
            'label' => $this->trans('form.translations.label')
        ]));

        $languageData->addChild($builder->getElement('rich_text_editor', [
            'name'  => 'content',
            'label' => $this->trans('news.content.label'),
        ]));

        $form->addFilter('trim');
        $form->addFilter('secure');

        return $form;
    }
}
