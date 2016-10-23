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
namespace WellCommerce\Bundle\NewsBundle\Form\Admin;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Bundle\NewsBundle\Repository\NewsRepositoryInterface;
use WellCommerce\Component\Form\DataTransformer\DateTransformer;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class NewsFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class NewsFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $repository = $this->getNewsRepository();
        
        $requiredData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('common.fieldset.general'),
        ]));
        
        $requiredData->addChild($this->getElement('checkbox', [
            'name'  => 'publish',
            'label' => $this->trans('common.label.publish'),
        ]));
        
        $requiredData->addChild($this->getElement('checkbox', [
            'name'  => 'featured',
            'label' => $this->trans('common.label.featured'),
        ]));
        
        $requiredData->addChild($this->getElement('date', [
            'name'        => 'startDate',
            'label'       => $this->trans('common.label.valid_from'),
            'transformer' => new DateTransformer('m/d/Y'),
        ]));
        
        $requiredData->addChild($this->getElement('date', [
            'name'        => 'endDate',
            'label'       => $this->trans('common.label.valid_to'),
            'transformer' => new DateTransformer('m/d/Y'),
        ]));
        
        $languageData = $requiredData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('common.fieldset.translations'),
            'transformer' => $this->getRepositoryTransformer('translation', $repository),
        ]));
        
        $name = $languageData->addChild($this->getElement('text_field', [
            'name'  => 'topic',
            'label' => $this->trans('news.label.topic'),
            'rules' => [
                $this->getRule('required'),
            ],
        ]));
        
        $languageData->addChild($this->getElement('slug_field', [
            'name'            => 'slug',
            'label'           => $this->trans('common.label.slug'),
            'name_field'      => $name,
            'generate_route'  => 'admin.routing.generate',
            'translatable_id' => $this->getRequestHelper()->getAttributesBagParam('id'),
            'rules'           => [
                $this->getRule('required'),
            ],
        ]));
        
        $languageData->addChild($this->getElement('rich_text_editor', [
            'name'  => 'summary',
            'label' => $this->trans('news.label.summary'),
        ]));
        
        $languageData->addChild($this->getElement('rich_text_editor', [
            'name'  => 'content',
            'label' => $this->trans('news.label.content'),
        ]));
        
        $mediaData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'media_data',
            'label' => $this->trans('common.fieldset.photos'),
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
        
        $this->addMetadataFieldset($form, $repository);
        
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
    
    private function getNewsRepository() : NewsRepositoryInterface
    {
        return $this->get('news.repository');
    }
}
