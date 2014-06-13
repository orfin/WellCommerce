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
namespace WellCommerce\Plugin\Producer\Form;

use WellCommerce\Core\Component\Form\AbstractForm;
use WellCommerce\Core\Component\Form\FormBuilder;
use WellCommerce\Core\Component\Form\FormInterface;
use WellCommerce\Core\Component\Model\ModelInterface;
use WellCommerce\Plugin\Producer\Model\Producer;

/**
 * Class ProducerForm
 *
 * @package WellCommerce\Plugin\Producer\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $form = $builder->addForm($options);

        $requiredData = $form->addChild($builder->addFieldset([
            'name'  => 'required_data',
            'label' => $this->trans('Basic settings')
        ]));

        $languageData = $requiredData->addChild($builder->addFieldsetLanguage([
            'name'      => 'language_data',
            'label'     => $this->trans('Language settings'),
            'languages' => $this->getLanguages()
        ]));

        $languageData->addChild($builder->addTextField([
            'name'  => 'name',
            'label' => $this->trans('Name'),
            'rules' => [
                $builder->addRuleRequired($this->trans('Name is required')),
                $builder->addRuleUnique($this->trans('Producer already exists'),
                    [
                        'table'   => 'producer_translation',
                        'column'  => 'name',
                        'exclude' => [
                            'column' => 'producer_id',
                            'values' => $this->getParam('id')
                        ]
                    ]
                )
            ]
        ]));

        $languageData->addChild($builder->addTextField([
            'name'  => 'slug',
            'label' => $this->trans('Slug'),
            'rules' => [
                $builder->addRuleRequired($this->trans('Slug is required')),
                $builder->addRuleUnique($this->trans('Slug already exists'),
                    [
                        'table'   => 'producer_translation',
                        'column'  => 'slug',
                        'exclude' => [
                            'column' => 'producer_id',
                            'values' => $this->getParam('id')
                        ]
                    ]
                )
            ]
        ]));

        $requiredData->addChild($builder->addMultiSelect([
            'name'    => 'deliverers',
            'label'   => 'Deliverers',
            'options' => $builder->makeOptions($this->get('deliverer.repository')->getAllDelivererToSelect())
        ]));

        $descriptionData = $form->addChild($builder->addFieldset([
            'name'  => 'description_data',
            'label' => $this->trans('Description')
        ]));

        $languageData = $descriptionData->addChild($builder->addFieldsetLanguage([
            'name'      => 'language_data',
            'label'     => $this->trans('Language settings'),
            'languages' => $this->getLanguages()
        ]));

        $languageData->addChild($builder->addRichTextEditor([
            'name'  => 'short_description',
            'label' => $this->trans('Short description'),
        ]));

        $languageData->addChild($builder->addRichTextEditor([
            'name'  => 'description',
            'label' => $this->trans('Description'),
        ]));

        $metaData = $form->addChild($builder->addFieldset([
            'name'  => 'meta_data',
            'label' => $this->trans('Seo settings')
        ]));

        $languageData = $metaData->addChild($builder->addFieldsetLanguage([
            'name'      => 'language_data',
            'languages' => $this->getLanguages()
        ]));

        $languageData->addChild($builder->addTextField([
            'name'  => 'meta_title',
            'label' => $this->trans('Meta title'),
        ]));

        $languageData->addChild($builder->addTextArea([
            'name'  => 'meta_keywords',
            'label' => $this->trans('Meta keywords'),
        ]));

        $languageData->addChild($builder->addTextArea([
            'name'  => 'meta_description',
            'label' => $this->trans('Meta description'),
        ]));

        $shopData = $form->addChild($builder->addFieldset([
            'name'  => 'shop_data',
            'label' => $this->trans('Shops')
        ]));

        $shopData->addChild($builder->addShopSelector([
            'name'   => 'shops',
            'label'  => $this->trans('Shops'),
            'stores' => $this->get('company.repository')->getShopsTree()
        ]));

        $form->addFilters([
            $builder->addFilterTrim(),
            $builder->addFilterSecure()
        ]);

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function prepareData(Producer $producer)
    {
        $populateData = [];
        $accessor     = $this->getPropertyAccessor();
        $languageData = $producer->translation->getTranslations();

        $accessor->setValue($populateData, '[required_data]', [
            'language_data' => $languageData,
            'deliverers'    => $producer->deliverer->getPrimaryKeys(),
        ]);

        $accessor->setValue($populateData, '[description_data][language_data]', $languageData);

        $accessor->setValue($populateData, '[meta_data][language_data]', $languageData);

        $accessor->setValue($populateData, '[shop_data][shops]', $producer->shop->getPrimaryKeys());

        return $populateData;
    }
}
