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
namespace WellCommerce\Bundle\ProductBundle\Form;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Bundle\FormBundle\DataTransformer\DateTransformer;
use WellCommerce\Bundle\FormBundle\Elements\ElementInterface;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;

/**
 * Class ProductFormBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $currencies = $this->get('currency.provider')->getSelect();
        $vatValues  = $this->get('tax.collection')->getSelect();

        $mainData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'main_data',
            'label' => $this->trans('admin.form.label.main_data')
        ]));

        $languageData = $mainData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('fieldset.language.label'),
            'transformer' => $this->getRepositoryTransformer('translation', $this->get('product.repository'))
        ]));

        $name = $languageData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('product.label.name'),
        ]));

        $languageData->addChild($this->getElement('slug_field', [
            'name'            => 'slug',
            'label'           => $this->trans('product.label.slug'),
            'name_field'      => $name,
            'generate_route'  => 'admin.routing.generate',
            'translatable_id' => $this->getParam('id')
        ]));

        $mainData->addChild($this->getElement('checkbox', [
            'name'    => 'enabled',
            'label'   => $this->trans('product.label.enabled'),
            'comment' => $this->trans('product.comment.enabled'),
            'default' => 1
        ]));

        $mainData->addChild($this->getElement('text_field', [
            'name'  => 'sku',
            'label' => $this->trans('product.label.sku'),
        ]));

        $mainData->addChild($this->getElement('select', [
            'name'        => 'producer',
            'label'       => $this->trans('product.label.producer'),
            'options'     => $this->get('producer.collection.admin')->getSelect(),
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('producer.repository')),
        ]));

        $metaData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'meta_data',
            'label' => $this->trans('meta.fieldset.name')
        ]));

        $languageData = $metaData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('fieldset.translations.label'),
            'transformer' => $this->getRepositoryTransformer('translation', $this->get('product.repository'))
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'meta.title',
            'label' => $this->trans('meta.label.title')
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'meta.keywords',
            'label' => $this->trans('meta.label.keywords'),
        ]));

        $languageData->addChild($this->getElement('text_area', [
            'name'  => 'meta.description',
            'label' => $this->trans('meta.label.description'),
        ]));

        $categoryPane = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'category_pane',
            'label' => $this->trans('fieldset.categories.label')
        ]));

        $categoriesField = $categoryPane->addChild($this->getElement('tree', [
            'name'        => 'categories',
            'label'       => $this->trans('product.label.categories'),
            'choosable'   => false,
            'selectable'  => true,
            'sortable'    => false,
            'clickable'   => false,
            'items'       => $this->get('category.collection.admin')->getFlatTree(),
            'transformer' => $this->getRepositoryTransformer('collection', $this->get('category.repository'))
        ]));

        $pricePane = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'price_pane',
            'label' => $this->trans('form.fieldset.prices')
        ]));

        $buyPriceSettings = $pricePane->addChild($this->getElement('nested_fieldset', [
            'name'  => 'buy_price_settings',
            'label' => $this->trans('product.label.buy_price.settings'),
            'class' => 'priceGroup'
        ]));

        $buyPriceSettings->addChild($this->getElement('select', [
            'name'    => 'buyPrice.currency',
            'label'   => $this->trans('product.label.buy_price.currency'),
            'options' => $currencies,
        ]));

        $buyPriceTax = $buyPriceSettings->addChild($this->getElement('select', [
            'name'            => 'buyPriceTax',
            'label'           => $this->trans('product.label.buy_price.tax'),
            'options'         => $vatValues,
            'addable'         => true,
            'onAdd'           => 'onTaxAdd',
            'add_item_prompt' => $this->trans('product.tax.add_item_prompt'),
            'transformer'     => $this->getRepositoryTransformer('entity', $this->get('tax.repository'))
        ]));

        $buyPriceSettings->addChild($this->getElement('price_editor', [
            'name'      => 'buyPrice.grossAmount',
            'label'     => $this->trans('product.label.buy_price.gross_amount'),
            'filters'   => [
                $this->getFilter('comma_to_dot_changer'),
            ],
            'vat_field' => $buyPriceTax,
        ]));

        $sellPriceSettings = $pricePane->addChild($this->getElement('nested_fieldset', [
            'name'  => 'sell_price_settings',
            'label' => $this->trans('product.label.sell_price.settings'),
            'class' => 'priceGroup'
        ]));

        $sellPriceSettings->addChild($this->getElement('select', [
            'name'    => 'sellPrice.currency',
            'label'   => $this->trans('product.label.sell_price.currency'),
            'options' => $currencies,
        ]));

        $sellPriceTax = $sellPriceSettings->addChild($this->getElement('select', [
            'name'            => 'sellPriceTax',
            'label'           => $this->trans('product.label.sell_price.tax'),
            'options'         => $vatValues,
            'addable'         => true,
            'onAdd'           => 'onTaxAdd',
            'add_item_prompt' => $this->trans('product.tax.add_item_prompt'),
            'transformer'     => $this->getRepositoryTransformer('entity', $this->get('tax.repository'))
        ]));

        $sellPriceAmount = $sellPriceSettings->addChild($this->getElement('price_editor', [
            'name'      => 'sellPrice.grossAmount',
            'label'     => $this->trans('product.label.sell_price.gross_amount'),
            'filters'   => [
                $this->getFilter('comma_to_dot_changer'),
            ],
            'vat_field' => $sellPriceTax,
        ]));

        $sellPriceSettings->addChild($this->getElement('price_editor', [
            'name'      => 'sellPrice.discountedGrossAmount',
            'label'     => $this->trans('product.label.sell_price.discounted_gross_amount'),
            'filters'   => [
                $this->getFilter('comma_to_dot_changer'),
            ],
            'vat_field' => $sellPriceTax,
        ]));

        $sellPriceSettings->addChild($this->getElement('date', [
            'name'        => 'sellPrice.validFrom',
            'label'       => $this->trans('product.label.sell_price.discount_valid_from'),
            'transformer' => new DateTransformer('m/d/Y'),
        ]));

        $sellPriceSettings->addChild($this->getElement('date', [
            'name'        => 'sellPrice.validTo',
            'label'       => $this->trans('product.label.sell_price.discount_valid_to'),
            'transformer' => new DateTransformer('m/d/Y')
        ]));

        $stockData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'stock_data',
            'label' => $this->trans('product.label.stock.settings')
        ]));

        $stockData->addChild($this->getElement('text_field', [
            'name'    => 'stock',
            'label'   => $this->trans('product.label.stock'),
            'suffix'  => $this->trans('pcs'),
            'default' => 0
        ]));

        $stockData->addChild($this->getElement('checkbox', [
            'name'    => 'trackStock',
            'label'   => $this->trans('product.label.track_stock'),
            'comment' => $this->trans('product.comment.track_stock'),
        ]));

        $stockData->addChild($this->getElement('select', [
            'name'        => 'unit',
            'label'       => $this->trans('product.label.unit'),
            'options'     => $this->get('unit.collection')->getSelect(),
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('unit.repository'))
        ]));

        $stockData->addChild($this->getElement('text_field', [
            'name'    => 'weight',
            'label'   => $this->trans('product.label.weight'),
            'filters' => [
                $this->getFilter('comma_to_dot_changer'),
            ],
            'default' => 0
        ]));

        $stockData->addChild($this->getElement('text_field', [
            'name'    => 'dimension.width',
            'label'   => $this->trans('product.label.dimension.width'),
            'filters' => [
                $this->getFilter('comma_to_dot_changer'),
            ],
        ]));

        $stockData->addChild($this->getElement('text_field', [
            'name'    => 'dimension.height',
            'label'   => $this->trans('product.label.dimension.height'),
            'filters' => [
                $this->getFilter('comma_to_dot_changer'),
            ],
        ]));

        $stockData->addChild($this->getElement('text_field', [
            'name'    => 'dimension.depth',
            'label'   => $this->trans('product.label.dimension.depth'),
            'filters' => [
                $this->getFilter('comma_to_dot_changer'),
            ],
        ]));

        $stockData->addChild($this->getElement('text_field', [
            'name'    => 'packageSize',
            'label'   => $this->trans('product.label.package_size'),
            'filters' => [
                $this->getFilter('comma_to_dot_changer'),
            ],
            'default' => 1
        ]));

        $availabilityField = $stockData->addChild($this->getElement('select', [
            'name'        => 'availability',
            'label'       => $this->trans('product.label.availability'),
            'options'     => $this->get('availability.collection')->getSelect(),
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('availability.repository'))
        ]));

        $mediaData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'media_data',
            'label' => $this->trans('product.label.product_photos')
        ]));

        $mediaData->addChild($this->getElement('image', [
            'name'         => 'productPhotos',
            'label'        => $this->trans('product.label.product_photos'),
            'load_route'   => $this->getRouterHelper()->generateUrl('admin.media.grid'),
            'upload_url'   => $this->getRouterHelper()->generateUrl('admin.media.add'),
            'repeat_min'   => 0,
            'repeat_max'   => ElementInterface::INFINITE,
            'transformer'  => $this->getRepositoryTransformer('product_photo_collection', $this->get('media.repository')),
            'session_name' => $this->getRequestHelper()->getCurrentRequest()->getSession()->getName(),
            'session_id'   => $this->getRequestHelper()->getCurrentRequest()->getSession()->getId(),
        ]));

        $statusesData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'statuses_data',
            'label' => $this->trans('product.label.statuses')
        ]));

        $statusesData->addChild($this->getElement('multi_select', [
            'name'        => 'statuses',
            'label'       => $this->trans('product.label.statuses'),
            'options'     => $this->get('product_status.collection.admin')->getSelect(),
            'transformer' => $this->getRepositoryTransformer('collection', $this->get('product_status.repository'))
        ]));

        $attributesData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'attributes_data',
            'label' => $this->trans('product.label.attributes')
        ]));

        $attributesData->addChild($this->getElement('product_variants_editor', [
            'name'               => 'attributes',
            'label'              => $this->trans('product.label.attributes'),
            'suffixes'           => ['+', '-', '%'],
            'price_field'        => $sellPriceAmount,
            'vat_field'          => $sellPriceTax,
            'vat_values'         => $vatValues,
            'category_field'     => $categoriesField,
            'availability_field' => $availabilityField,
            'availability'       => $availabilityField->getOption('options'),
            'transformer'        => $this->getRepositoryTransformer('product_attribute_collection', $this->get('product_attribute.repository'))
        ]));

        $shopsData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'shops_data',
            'label' => $this->trans('shop.label.shops')
        ]));

        $shopsData->addChild($this->getElement('multi_select', [
            'name'        => 'shops',
            'label'       => $this->trans('product.label.shops'),
            'options'     => $this->get('shop.collection')->getSelect(),
            'transformer' => $this->getRepositoryTransformer('collection', $this->get('shop.repository'))
        ]));

        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
