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
namespace WellCommerce\Plugin\Layout\Form;

use WellCommerce\Core\Component\Form\AbstractForm;
use WellCommerce\Core\Component\Form\Elements\ElementInterface;
use WellCommerce\Core\Component\Form\FormBuilder;
use WellCommerce\Core\Component\Form\FormInterface;
use WellCommerce\Plugin\Layout\Model\LayoutPage;

/**
 * Class LayoutPageForm
 *
 * @package WellCommerce\Plugin\LayoutPage\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutPageForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $form = $builder->addForm($options);

        $pages = $this->get('layout_page.repository')->all();

//        print_r($pages);die();

//        $layoutBoxConfigurators = $this->getLayoutManager()->getLayoutBoxConfigurators();

        foreach ($pages as $page) {

            $columnData = $form->addChild($builder->addFieldset([
                'name'  => $page->id,
                'label' => $page->name
            ]));

            $columnDataColumns = $columnData->addChild($builder->addFieldsetRepeatable([
                'name'       => 'columns_data',
                'repeat_min' => 1,
                'repeat_max' => ElementInterface::INFINITE
            ]));

            $columnDataColumns->addChild($builder->addTip([
                'tip'         => '<p>' . $this->trans('To extend the column to all remaining width please enter') . ' <strong>0</strong>.</p>',
                'retractable' => false
            ]));

            $boxData = $columnDataColumns->addChild($builder->addLayoutBoxesList([
                'name'  => 'layout_boxes',
                'label' => $this->trans('Choose boxes'),
                'boxes' => $builder->makeOptions([])
            ]));
        }

        $form->addFilters([
            $builder->addFilterNoCode(),
            $builder->addFilterTrim(),
            $builder->addFilterSecure()
        ]);

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function prepareData(LayoutPage $layoutPage)
    {
        $formData     = [];
//        $accessor     = $this->getPropertyAccessor();
//        $languageData = $category->translation->getTranslations();
//
//        $accessor->setValue($formData, '[required_data]', [
//            'enabled'       => $category->enabled,
//            'parent_id'     => $category->parent_id,
//            'hierarchy'     => $category->hierarchy,
//            'language_data' => $languageData
//        ]);
//
//        $accessor->setValue($formData, '[meta_data]', [
//            'language_data' => $languageData
//        ]);
//
//        $accessor->setValue($formData, '[description_data]', [
//            'language_data' => $languageData
//        ]);
//
//        $accessor->setValue($formData, '[shop_data]', [
//            'shops' => $category->shop->getPrimaryKeys()
//        ]);
//
        return $formData;
    }
}
