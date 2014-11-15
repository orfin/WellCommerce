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
namespace WellCommerce\Bundle\ProducerBundle\Form;

use WellCommerce\Bundle\FormBundle\Form\AbstractForm;
use WellCommerce\Bundle\FormBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\FormBundle\Form\DataTransformer\CollectionToArrayTransformer;
use WellCommerce\Bundle\FormBundle\Form\FormInterface;
use WellCommerce\Bundle\MediaBundle\Form\DataTransformer\MediaEntityToIdentifierTransformer;

/**
 * Class ProducerForm
 *
 * @package WellCommerce\Producer\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerForm extends AbstractForm implements FormInterface
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

        $languageData = $requiredData->addChild($builder->getElement('fieldset_language', [
            'name'  => 'translations',
            'label' => $this->trans('form.required_data.language_data.label')
        ]));

        $name = $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('producer.name.label'),
        ]));

        $languageData->addChild($builder->getElement('slug_field', [
            'name'            => 'slug',
            'label'           => $this->trans('producer.slug.label'),
            'name_field'      => $name,
            'generate_route'  => 'admin.routing.generate',
            'translatable_id' => $this->getParam('id')
        ]));

        $mediaData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'media_data',
            'label' => $this->trans('fieldset.media')
        ]));

        $mediaData->addChild($builder->getElement('image', [
            'name'        => 'photo',
            'label'       => $this->trans('form.media_data.image_id'),
            'load_route'  => $this->generateUrl('admin.media.grid'),
            'upload_url'  => $this->generateUrl('admin.media.add'),
            'repeat_min'  => 0,
            'repeat_max'  => 1,
            'transformer' => new MediaEntityToIdentifierTransformer($this->get('media.repository'))
        ]));

        $delivererData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'deliverers_data',
            'label' => $this->trans('producer.deliverers.label')
        ]));

        $delivererData->addChild($builder->getElement('multi_select', [
            'name'        => 'deliverers',
            'label'       => $this->trans('deliverers'),
            'options'     => $this->get('deliverer.repository')->getCollectionToSelect(),
            'transformer' => new CollectionToArrayTransformer($this->get('deliverer.repository'))
        ]));

        $form->addFilter('no_code');
        $form->addFilter('trim');
        $form->addFilter('secure');

        return $form;
    }
}
