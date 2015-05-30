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

use WellCommerce\Bundle\FormBundle\Builder\AbstractFormBuilder;
use WellCommerce\Bundle\FormBundle\DataTransformer\CollectionToArrayTransformer;
use WellCommerce\Bundle\FormBundle\DataTransformer\EntityToIdentifierTransformer;
use WellCommerce\Bundle\FormBundle\DataTransformer\TranslationTransformer;
use WellCommerce\Bundle\FormBundle\Elements\ElementInterface;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;
use WellCommerce\Bundle\ProductBundle\Form\DataTransformer\ProductAttributeCollectionToArrayTransformer;
use WellCommerce\Bundle\ProductBundle\Form\DataTransformer\ProductPhotoCollectionToArrayTransformer;

/**
 * Class ProductForm
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
            'label' => $this->trans('fieldset.main.label')
        ]));

        $languageData = $mainData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('fieldset.language.label'),
            'transformer' => new TranslationTransformer($this->get('product.repository'))
        ]));

        $name = $languageData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('product.name.label'),
        ]));

        $languageData->addChild($this->getElement('slug_field', [
            'name'            => 'slug',
            'label'           => $this->trans('product.slug.label'),
            'name_field'      => $name,
            'generate_route'  => 'admin.routing.generate',
            'translatable_id' => $this->getParam('id')
        ]));

        $mainData->addChild($this->getElement('checkbox', [
            'name'    => 'enabled',
            'label'   => $this->trans('product.enabled.label'),
            'comment' => $this->trans('product.enabled.comment'),
            'default' => 1
        ]));

        $mainData->addChild($this->getElement('text_field', [
            'name'  => 'sku',
            'label' => $this->trans('product.sku.label'),
        ]));

        $mainData->addChild($this->getElement('select', [
            'name'        => 'producer',
            'label'       => $this->trans('product.producer.label'),
            'options'     => $this->get('producer.collection.admin')->getSelect(),
            'transformer' => new EntityToIdentifierTransformer($this->get('producer.repository'))
        ]));

        $metaData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'meta_data',
            'label' => $this->trans('fieldset.meta.label')
        ]));

        $languageData = $metaData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('fieldset.translations.label'),
            'transformer' => new TranslationTransformer($this->get('product.repository'))
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'meta.title',
            'label' => $this->trans('meta.title.label')
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'meta.keywords',
            'label' => $this->trans('meta.keywords.label'),
        ]));

        $languageData->addChild($this->getElement('text_area', [
            'name'  => 'meta.description',
            'label' => $this->trans('meta.description.label'),
        ]));

        $categoryPane = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'category_pane',
            'label' => $this->trans('fieldset.categories.label')
        ]));

        $categoriesField = $categoryPane->addChild($this->getElement('tree', [
            'name'        => 'categories',
            'label'       => $this->trans('product.categories.label'),
            'choosable'   => false,
            'selectable'  => true,
            'sortable'    => false,
            'clickable'   => false,
            'items'       => $this->get('category.collection.admin')->getFlatTree(),
            'transformer' => new CollectionToArrayTransformer($this->get('category.repository'))
        ]));

        $pricePane = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'price_pane',
            'label' => $this->trans('fieldset.prices.label')
        ]));

        $buyPriceSettings = $pricePane->addChild($this->getElement('nested_fieldset', [
            'name'  => 'buy_price_settings',
            'label' => $this->trans('product.buy_price.settings.label'),
            'class' => 'priceGroup'
        ]));

        $buyPriceSettings->addChild($this->getElement('select', [
            'name'    => 'buyPrice.currency',
            'label'   => $this->trans('product.buy_price.currency.label'),
            'options' => $currencies,
        ]));

        $buyPriceTax = $buyPriceSettings->addChild($this->getElement('select', [
            'name'            => 'buyPrice.tax',
            'label'           => $this->trans('product.buy_price.tax.label'),
            'options'         => $vatValues,
            'addable'         => true,
            'onAdd'           => 'onTaxAdd',
            'add_item_prompt' => $this->trans('product.tax.add_item_prompt'),
        ]));

        $buyPriceSettings->addChild($this->getElement('price_editor', [
            'name'      => 'buyPrice.amount',
            'label'     => $this->trans('product.buy_price.amount.label'),
            'filters'   => [
                $this->getFilter('comma_to_dot_changer'),
            ],
            'vat_field' => $buyPriceTax,
        ]));

        $sellPriceSettings = $pricePane->addChild($this->getElement('nested_fieldset', [
            'name'  => 'sell_price_settings',
            'label' => $this->trans('product.sell_price.settings.label'),
            'class' => 'priceGroup'
        ]));

        $sellPriceSettings->addChild($this->getElement('select', [
            'name'    => 'sellPrice.currency',
            'label'   => $this->trans('product.sell_price.currency.label'),
            'options' => $currencies,
        ]));

        $sellPriceTax = $sellPriceSettings->addChild($this->getElement('select', [
            'name'            => 'sellPrice.tax',
            'label'           => $this->trans('product.sell_price.tax.label'),
            'options'         => $vatValues,
            'addable'         => true,
            'onAdd'           => 'onTaxAdd',
            'add_item_prompt' => $this->trans('product.tax.add_item_prompt'),
        ]));

        $sellPriceAmount = $sellPriceSettings->addChild($this->getElement('price_editor', [
            'name'      => 'sellPrice.amount',
            'label'     => $this->trans('product.sell_price.amount.label'),
            'filters'   => [
                $this->getFilter('comma_to_dot_changer'),
            ],
            'vat_field' => $sellPriceTax,
        ]));

        $stockData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'stock_data',
            'label' => $this->trans('Stock settings')
        ]));

        $stockData->addChild($this->getElement('text_field', [
            'name'    => 'stock',
            'label'   => $this->trans('product.stock.label'),
            'suffix'  => $this->trans('pcs'),
            'default' => 0
        ]));

        $stockData->addChild($this->getElement('checkbox', [
            'name'    => 'trackStock',
            'label'   => $this->trans('product.track_stock.label'),
            'comment' => $this->trans('Enable stock tracking for product'),
        ]));

        $stockData->addChild($this->getElement('select', [
            'name'        => 'unit',
            'label'       => $this->trans('product.unit.label'),
            'options'     => $this->get('unit.collection')->getSelect(),
            'transformer' => new EntityToIdentifierTransformer($this->get('unit.repository'))
        ]));

        $stockData->addChild($this->getElement('text_field', [
            'name'    => 'weight',
            'label'   => $this->trans('product.weight.label'),
            'filters' => [
                $this->getFilter('comma_to_dot_changer'),
            ],
            'default' => 0
        ]));

        $stockData->addChild($this->getElement('text_field', [
            'name'    => 'dimension.width',
            'label'   => $this->trans('product.dimension.width.label'),
            'filters' => [
                $this->getFilter('comma_to_dot_changer'),
            ],
        ]));

        $stockData->addChild($this->getElement('text_field', [
            'name'    => 'dimension.height',
            'label'   => $this->trans('product.dimension.height.label'),
            'filters' => [
                $this->getFilter('comma_to_dot_changer'),
            ],
        ]));

        $stockData->addChild($this->getElement('text_field', [
            'name'    => 'dimension.depth',
            'label'   => $this->trans('product.dimension.depth.label'),
            'filters' => [
                $this->getFilter('comma_to_dot_changer'),
            ],
        ]));

        $stockData->addChild($this->getElement('text_field', [
            'name'    => 'packageSize',
            'label'   => $this->trans('product.package_size.label'),
            'filters' => [
                $this->getFilter('comma_to_dot_changer'),
            ],
            'default' => 1
        ]));

        $availabilityField = $stockData->addChild($this->getElement('select', [
            'name'        => 'availability',
            'label'       => $this->trans('product.availability.label'),
            'options'     => $this->get('availability.collection')->getSelect(),
            'transformer' => new EntityToIdentifierTransformer($this->get('availability.repository'))
        ]));

        $mediaData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'media_data',
            'label' => $this->trans('Photos')
        ]));

        $mediaData->addChild($this->getElement('image', [
            'name'         => 'productPhotos',
            'label'        => $this->trans('product.product_photos.label'),
            'load_route'   => $this->generateUrl('admin.media.grid'),
            'upload_url'   => $this->generateUrl('admin.media.add'),
            'repeat_min'   => 0,
            'repeat_max'   => ElementInterface::INFINITE,
            'transformer'  => new ProductPhotoCollectionToArrayTransformer($this->get('media.repository')),
            'session_name' => $this->getRequest()->getSession()->getName(),
            'session_id'   => $this->getRequest()->getSession()->getId(),
        ]));

        $statusesData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'statuses_data',
            'label' => $this->trans('Statuses')
        ]));

        $statusesData->addChild($this->getElement('multi_select', [
            'name'        => 'statuses',
            'label'       => $this->trans('Statuses'),
            'options'     => $this->get('product_status.collection.admin')->getSelect(),
            'transformer' => new CollectionToArrayTransformer($this->get('product_status.repository'))
        ]));

        $attributesData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'attributes_data',
            'label' => $this->trans('Attributes')
        ]));

        $attributesData->addChild($this->getElement('product_variants_editor', [
            'name'               => 'attributes',
            'label'              => $this->trans('Attributes'),
            'price_field'        => $sellPriceAmount,
            'vat_field'          => $sellPriceTax,
            'vat_values'         => $vatValues,
            'category_field'     => $categoriesField,
            'availability_field' => $availabilityField,
            'availability'       => $availabilityField->getOption('options'),
            'transformer'        => new ProductAttributeCollectionToArrayTransformer($this->get('product_attribute.repository'))
        ]));

        $shopsData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'shops_data',
            'label' => $this->trans('fieldset.shops.label')
        ]));

        $shopsData->addChild($this->getElement('multi_select', [
            'name'        => 'shops',
            'label'       => $this->trans('shops.label'),
            'options'     => $this->get('shop.collection')->getSelect(),
            'transformer' => new CollectionToArrayTransformer($this->get('shop.repository'))
        ]));

        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
