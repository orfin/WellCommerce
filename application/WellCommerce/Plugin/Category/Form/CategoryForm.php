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
namespace WellCommerce\Plugin\Category\Form;

use WellCommerce\Core\Component\Form\AbstractForm;
use WellCommerce\Core\Component\Form\FormBuilder;
use WellCommerce\Core\Component\Form\FormInterface;
use WellCommerce\Plugin\Category\Model\Category;

/**
 * Class CategoryForm
 *
 * @package WellCommerce\Plugin\Category\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryForm extends AbstractForm implements FormInterface
{
    /**
     * Registers functions needed in categories tree
     */
    private function registerFunctions()
    {
        $this->getXajax()->registerFunction([
            'doAJAXRefreshSeoCategory',
            $this->get('category.repository'),
            'doAJAXRefreshSeoCategory'
        ]);

        $this->getXajaxManager()->registerFunction([
            'doAJAXCreateSeoCategory',
            $this->get('category.repository'),
            'doAJAXCreateSeoCategory'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $this->registerFunctions();

        $form = $builder->addForm($options);

        $requiredData = $form->addChild($builder->addFieldset([
            'name'  => 'required_data',
            'label' => $this->trans('Required data')
        ]));

        $languageData = $requiredData->addChild($builder->addFieldsetLanguage([
            'name'  => 'language_data',
            'label' => $this->trans('Translations')
        ]));

        $languageData->addChild($builder->addTextField([
            'name'  => 'name',
            'label' => $this->trans('Name'),
            'rules' => [
                $builder->addRuleRequired('Name is required')
            ]
        ]));

        $languageData->addChild($builder->addTextField([
            'name'    => 'slug',
            'label'   => $this->trans('Slug'),
            'comment' => $this->trans('Only alphanumeric characters'),
            'rules'   => [
                $builder->addRuleRequired($this->trans('Slug is required')),
                $builder->addRuleFormat($this->trans('Only alphanumeric characters are allowed'), '/^[A-Za-z0-9-_\/\",\'\s]+$/'),
                $builder->addRuleLanguageUnique($this->trans('Slug already exists'),
                    [
                        'table'   => 'category_translation',
                        'column'  => 'slug',
                        'exclude' => [
                            'column' => 'category_id',
                            'values' => $this->getParam('id')
                        ]
                    ]
                )
            ]
        ]));

        $requiredData->addChild($builder->addCheckBox([
            'name'    => 'enabled',
            'label'   => $this->trans('Enabled'),
            'comment' => $this->trans('Only enabled categories are visible in shop'),
            'default' => '1'
        ]));

        $requiredData->addChild($builder->addTextField([
            'name'    => 'hierarchy',
            'label'   => $this->trans('Hierarchy'),
            'comment' => $this->trans('Hierarchy uses ascending order'),
        ]));

        $requiredData->addChild($builder->addTip([
            'tip' => '<p>' . $this->trans('Choose parent category') . '</p>'
        ]));

        $requiredData->addChild($builder->addTree([
            'name'       => 'parent_id',
            'label'      => $this->trans('Parent category'),
            'choosable'  => true,
            'selectable' => false,
            'sortable'   => false,
            'clickable'  => false,
            'items'      => $this->get('category.repository')->getCategoriesTree(),
            'restrict'   => $this->getParam('id'),
            'rules'      => [
                $builder->addRuleCustom($this->trans('Category cannot be parent itself'), function ($id) {
                    return ($id != $this->getParam('id'));
                })
            ],
        ]));

        $metaData = $form->addChild($builder->addFieldset([
            'name'  => 'meta_data',
            'label' => $this->trans('Meta settings')
        ]));

        $metaData->addChild($builder->addTip([
            'tip' => '<p>' . $this->trans('Lack of meta settings will cause in automatic generation using default shop settings.') . '</p>'
        ]));

        $languageData = $metaData->addChild($builder->addFieldsetLanguage([
            'name'  => 'language_data',
            'label' => $this->trans('Translations'),
        ]));

        $languageData->addChild($builder->addTextField([
            'name'  => 'meta_title',
            'label' => $this->trans('Title')
        ]));

        $languageData->addChild($builder->addTextArea([
            'name'  => 'meta_keywords',
            'label' => $this->trans('Keywords'),
        ]));

        $languageData->addChild($builder->addTextArea([
            'name'  => 'meta_description',
            'label' => $this->trans('Description'),
        ]));

        $descriptionPane = $form->addChild($builder->addFieldset([
            'name'  => 'description_data',
            'label' => $this->trans('Category descriptions')
        ]));

        $descriptionLanguageData = $descriptionPane->addChild($builder->addFieldsetLanguage([
            'name'  => 'language_data',
            'label' => $this->trans('Translations'),
        ]));

        $descriptionLanguageData->addChild($builder->addRichTextEditor([
            'name'  => 'short_description',
            'label' => $this->trans('Short description'),
            'rows'  => 20
        ]));

        $descriptionLanguageData->addChild($builder->addRichTextEditor([
            'name'  => 'description',
            'label' => $this->trans('Description'),
            'rows'  => 30
        ]));

        $shopData = $form->addChild($builder->addFieldset([
            'name'  => 'shop_data',
            'label' => $this->trans('Shops')
        ]));

        $shopData->addChild($builder->addShopSelector([
            'name'  => 'shops',
            'label' => $this->trans('Shops')
        ]));

        $form->addFilters([
            $builder->addFilterTrim(),
            $builder->addFilterSecure()
        ]);

        return $form;
    }

    /**
     * Prepares populate data using retrieved Category model data
     *
     * @param Category $category Category model
     *
     * @return array
     */
    public function prepareData(Category $category)
    {
        $formData     = [];
        $accessor     = $this->getPropertyAccessor();
        $languageData = $category->translations->getTranslations();

        $accessor->setValue($formData, '[required_data]', [
            'enabled'       => $category->enabled,
            'parent_id'     => $category->parent_id,
            'hierarchy'     => $category->hierarchy,
            'language_data' => $languageData
        ]);

        $accessor->setValue($formData, '[meta_data]', [
            'language_data' => $languageData
        ]);

        $accessor->setValue($formData, '[description_data]', [
            'language_data' => $languageData
        ]);

        $accessor->setValue($formData, '[shop_data]', [
            'shops' => $category->shop->getPrimaryKeys()
        ]);

        return $formData;
    }
}
