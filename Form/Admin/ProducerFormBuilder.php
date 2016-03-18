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
namespace WellCommerce\Bundle\ProducerBundle\Form\Admin;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class ProducerFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $requiredData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('common.fieldset.general')
        ]));

        $languageData = $requiredData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('common.fieldset.translations'),
            'transformer' => $this->getRepositoryTransformer('translation', $this->get('product.repository'))
        ]));

        $name = $languageData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('common.label.name'),
            'rules' => [
                $this->getRule('required')
            ],
        ]));

        $languageData->addChild($this->getElement('slug_field', [
            'name'            => 'slug',
            'label'           => $this->trans('common.label.slug'),
            'name_field'      => $name,
            'generate_route'  => 'admin.routing.generate',
            'translatable_id' => $this->getRequestHelper()->getAttributesBagParam('id'),
            'rules'           => [
                $this->getRule('required')
            ],
        ]));

        $this->addMetadataFieldset($form, $this->get('producer.repository'));

        $mediaData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'media_data',
            'label' => $this->trans('common.fieldset.photos')
        ]));

        $mediaData->addChild($this->getElement('image', [
            'name'         => 'photo',
            'label'        => $this->trans('form.media_data.image_id'),
            'load_route'   => $this->getRouterHelper()->generateUrl('admin.media.grid'),
            'upload_url'   => $this->getRouterHelper()->generateUrl('admin.media.add'),
            'repeat_min'   => 0,
            'repeat_max'   => 1,
            'transformer'  => $this->getRepositoryTransformer('media_entity', $this->get('media.repository')),
            'session_id'   => $this->getRequestHelper()->getSessionId(),
            'session_name' => $this->getRequestHelper()->getSessionName(),
        ]));

        $delivererData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'deliverers_data',
            'label' => $this->trans('producer.fieldset.deliverers')
        ]));

        $delivererData->addChild($this->getElement('multi_select', [
            'name'        => 'deliverers',
            'label'       => $this->trans('producer.label.deliverers'),
            'options'     => $this->get('deliverer.dataset.admin')->getResult('select'),
            'transformer' => $this->getRepositoryTransformer('collection', $this->get('deliverer.repository'))
        ]));

        $this->addShopsFieldset($form);

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
