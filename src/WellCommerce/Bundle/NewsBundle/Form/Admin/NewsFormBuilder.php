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
            'label' => $this->trans('common.fieldset.general')
        ]));

        $languageData = $requiredData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('common.fieldset.translations'),
            'transformer' => $this->getRepositoryTransformer('translation', $repository)
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'topic',
            'label' => $this->trans('news.label.topic'),
            'rules' => [
                $this->getRule('required')
            ],
        ]));

        $languageData->addChild($this->getElement('text_area', [
            'name'  => 'summary',
            'label' => $this->trans('news.label.summary'),
        ]));

        $languageData->addChild($this->getElement('text_area', [
            'name'  => 'content',
            'label' => $this->trans('news.label.content'),
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
