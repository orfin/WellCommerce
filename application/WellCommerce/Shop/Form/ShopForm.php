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
namespace WellCommerce\Shop\Form;

use WellCommerce\Core\Form\AbstractForm;
use WellCommerce\Core\Form\Builder\FormBuilderInterface;
use WellCommerce\Core\Form\FormInterface;
use WellCommerce\Shop\Model\Shop;

/**
 * Class ShopForm
 *
 * @package WellCommerce\Shop\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form = $builder->addForm($options);

        $requiredData = $form->addChild($builder->addFieldset([
            'name'  => 'required_data',
            'label' => $this->trans('Required data')
        ]));

        $languageData = $requiredData->addChild($builder->addFieldsetLanguage([
            'name'      => 'language_data',
            'languages' => $this->getLanguages()
        ]));

        $languageData->addChild($builder->addTextField([
            'name'  => 'name',
            'label' => $this->trans('Name'),
            'rules' => [
                $builder->addRuleRequired($this->trans('Name is required')),
            ]
        ]));

        $requiredData->addChild($builder->addTextField([
            'name'    => 'url',
            'label'   => $this->trans('Url'),
            'comment' => $this->trans('Enter shop URL address'),
            'rules'   => [
                $builder->addRuleRequired($this->trans('Url is required')),
                $builder->addRuleCustom($this->trans('Url address is not valid'), function ($value) {
                    return filter_var($value, FILTER_VALIDATE_URL);
                })
            ]
        ]));

        $requiredData->addChild($builder->addCheckBox([
            'name'    => 'offline',
            'label'   => $this->trans('Offline mode'),
            'comment' => $this->trans('Turn shop into offline mode.')
        ]));

        $requiredData->addChild($builder->addSelect([
            'name'    => 'company_id',
            'label'   => $this->trans('Company'),
            'options' => $builder->makeOptions($this->get('company.repository')->getAllCompanyToSelect()),
            'rules'   => [
                $builder->addRuleRequired($this->trans('Company is required'))
            ]
        ]));

        $requiredData->addChild($builder->addSelect([
            'name'    => 'layout_theme_id',
            'label'   => $this->trans('Theme'),
            'options' => $builder->makeOptions($this->get('layout_theme.repository')->getAllLayoutThemeToSelect()),
            'rules'   => [
                $builder->addRuleRequired($this->trans('Theme is required'))
            ]
        ]));

        $metaData = $form->addChild($builder->addFieldset([
            'name'  => 'meta_data',
            'label' => $this->trans('Seo settings')
        ]));

        $languageData = $metaData->addChild($builder->addFieldsetLanguage([
            'name' => 'language_data',
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

        $form->addFilters([
            $builder->addFilterTrim(),
            $builder->addFilterSecure()
        ]);

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function prepareData(Shop $shop)
    {
        $formData     = [];
        $accessor     = $this->getPropertyAccessor();
        $languageData = $shop->translation->getTranslations();

        $accessor->setValue($formData, '[required_data]', [
            'url'             => $shop->url,
            'offline'         => $shop->offline,
            'company_id'      => $shop->company_id,
            'layout_theme_id' => $shop->layout_theme_id,
            'language_data'   => $languageData
        ]);

        $accessor->setValue($formData, '[meta_data]', [
            'language_data' => $languageData
        ]);

        return $formData;
    }
}
