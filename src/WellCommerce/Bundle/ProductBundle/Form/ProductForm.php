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

use WellCommerce\Bundle\FormBundle\Form\AbstractForm;
use WellCommerce\Bundle\FormBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\FormBundle\Form\DataTransformer\CollectionToArrayTransformer;
use WellCommerce\Bundle\FormBundle\Form\DataTransformer\EntityToIdentifierTransformer;
use WellCommerce\Bundle\FormBundle\Form\Elements\ElementInterface;
use WellCommerce\Bundle\FormBundle\Form\FormInterface;
use WellCommerce\Bundle\MediaBundle\Form\DataTransformer\MediaCollectionToArrayTransformer;
use WellCommerce\Bundle\ProductBundle\Form\DataTransformer\ProductAttributeCollectionToArrayTransformer;

/**
 * Class ProductForm
 *
 * @package WellCommerce\Product\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form       = $builder->init($options);
        $currencies = $this->get('currency.repository')->getCollectionToSelect('code');
        $vatValues  = $this->get('tax.repository')->getCollectionToSelect();

        $mainData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'main_data',
            'label' => $this->trans('fieldset.main.label')
        ]));

        $languageData = $mainData->addChild($builder->getElement('fieldset_language', [
            'name'  => 'translations',
            'label' => $this->trans('fieldset.language.label')
        ]));

        $name = $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('product.name.label'),
        ]));

        $languageData->addChild($builder->getElement('slug_field', [
            'name'            => 'slug',
            'label'           => $this->trans('product.slug.label'),
            'name_field'      => $name,
            'generate_route'  => 'admin.routing.generate',
            'translatable_id' => $this->getParam('id')
        ]));

        $mainData->addChild($builder->getElement('checkbox', [
            'name'    => 'enabled',
            'label'   => $this->trans('product.enabled.label'),
            'comment' => $this->trans('product.enabled.comment'),
            'default' => 1
        ]));

        $mainData->addChild($builder->getElement('text_field', [
            'name'  => 'sku',
            'label' => $this->trans('product.sku.label'),
        ]));


        $mainData->addChild($builder->getElement('select', [
            'name'        => 'producer',
            'label'       => $this->trans('product.producer.label'),
            'options'     => $this->get('producer.repository')->getCollectionToSelect(),
            'transformer' => new EntityToIdentifierTransformer($this->get('producer.repository'))
        ]));

        $metaData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'meta_data',
            'label' => $this->trans('fieldset.meta.label')
        ]));

        $languageData = $metaData->addChild($builder->getElement('fieldset_language', [
            'name'  => 'translations',
            'label' => $this->trans('fieldset.translations.label'),
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'metaTitle',
            'label' => $this->trans('meta.title.label')
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'metaKeywords',
            'label' => $this->trans('meta.keywords.label'),
        ]));

        $languageData->addChild($builder->getElement('text_area', [
            'name'  => 'metaDescription',
            'label' => $this->trans('meta.description.label'),
        ]));

        $categoryPane = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'category_pane',
            'label' => $this->trans('fieldset.categories.label')
        ]));

        $categoriesField = $categoryPane->addChild($builder->getElement('tree', [
            'name'        => 'categories',
            'label'       => $this->trans('product.categories.label'),
            'choosable'   => false,
            'selectable'  => true,
            'sortable'    => false,
            'clickable'   => false,
            'items'       => $this->get('category.repository')->getTreeItems(),
            'transformer' => new CollectionToArrayTransformer($this->get('category.repository'))
        ]));

        $pricePane = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'price_pane',
            'label' => $this->trans('fieldset.prices.label')
        ]));

        $vatField = $pricePane->addChild($builder->getElement('select', [
            'name'            => 'tax',
            'label'           => $this->trans('product.tax.label'),
            'options'         => $vatValues,
            'addable'         => true,
            'onAdd'           => 'onTaxAdd',
            'add_item_prompt' => $this->trans('product.tax.add_item_prompt'),
            'transformer'     => new EntityToIdentifierTransformer($this->get('tax.repository'))
        ]));

        $pricePane->addChild($builder->getElement('select', [
            'name'        => 'sellCurrency',
            'label'       => $this->trans('Currency for sell prices'),
            'options'     => $currencies,
            'transformer' => new EntityToIdentifierTransformer($this->get('currency.repository'))
        ]));

        $pricePane->addChild($builder->getElement('select', [
            'name'        => 'buyCurrency',
            'label'       => $this->trans('Currency for buy prices'),
            'options'     => $currencies,
            'transformer' => new EntityToIdentifierTransformer($this->get('currency.repository'))
        ]));

        $pricePane->addChild($builder->getElement('price', [
            'name'      => 'buyPrice',
            'label'     => $this->trans('Buy price'),
            'filters'   => [
                $builder->getFilter('comma_to_dot_changer')
            ],
            'vat_field' => $vatField,
        ]));

        $standardPrice = $pricePane->addChild($builder->getElement('fieldset', [
            'name'  => 'standard_price',
            'label' => $this->trans('Standard sell price'),
            'class' => 'priceGroup'
        ]));

        $priceField = $standardPrice->addChild($builder->getElement('price', [
            'name'      => 'sellPrice',
            'label'     => $this->trans('Sell price'),
            'filters'   => [
                $builder->getFilter('comma_to_dot_changer')
            ],
            'vat_field' => $vatField,
        ]));

        $stockData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'stock_data',
            'label' => $this->trans('Stock settings')
        ]));

        $stockData->addChild($builder->getElement('text_field', [
            'name'    => 'stock',
            'label'   => $this->trans('Stock'),
            'suffix'  => $this->trans('pcs'),
            'default' => 0
        ]));

        $stockData->addChild($builder->getElement('checkbox', [
            'name'    => 'trackStock',
            'label'   => $this->trans('Track stock'),
            'comment' => $this->trans('Enable stock tracking for product'),
        ]));

        $stockData->addChild($builder->getElement('select', [
            'name'        => 'unit',
            'label'       => $this->trans('Unit'),
            'options'     => $this->get('unit.repository')->getCollectionToSelect(),
            'transformer' => new EntityToIdentifierTransformer($this->get('unit.repository'))
        ]));

        $stockData->addChild($builder->getElement('text_field', [
            'name'    => 'weight',
            'label'   => $this->trans('Weight'),
            'filters' => [
                $builder->getFilter('comma_to_dot_changer')
            ],
            'default' => 0
        ]));

        $stockData->addChild($builder->getElement('text_field', [
            'name'    => 'width',
            'label'   => $this->trans('Width'),
            'filters' => [
                $builder->getFilter('comma_to_dot_changer')
            ],
        ]));

        $stockData->addChild($builder->getElement('text_field', [
            'name'    => 'height',
            'label'   => $this->trans('Height'),
            'filters' => [
                $builder->getFilter('comma_to_dot_changer')
            ],
        ]));

        $stockData->addChild($builder->getElement('text_field', [
            'name'    => 'depth',
            'label'   => $this->trans('Depth'),
            'filters' => [
                $builder->getFilter('comma_to_dot_changer')
            ],
        ]));

        $stockData->addChild($builder->getElement('text_field', [
            'name'    => 'package_size',
            'label'   => $this->trans('Package size'),
            'filters' => [
                $builder->getFilter('comma_to_dot_changer')
            ],
            'default' => 1
        ]));

        $availabilityField = $stockData->addChild($builder->getElement('select', [
            'name'        => 'availability',
            'label'       => $this->trans('Availability'),
            'options'     => $this->get('availability.repository')->getCollectionToSelect(),
            'transformer' => new EntityToIdentifierTransformer($this->get('availability.repository'))
        ]));

        $mediaData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'media_data',
            'label' => $this->trans('Photos')
        ]));

        $mediaData->addChild($builder->getElement('image', [
            'name'        => 'productPhotos',
            'label'       => $this->trans('Photos'),
            'load_route'  => $this->generateUrl('admin.media.grid'),
            'upload_url'  => $this->generateUrl('admin.media.add'),
            'repeat_min'  => 0,
            'repeat_max'  => ElementInterface::INFINITE,
            'transformer' => new MediaCollectionToArrayTransformer($this->get('media.repository'))
        ]));

        $statusesData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'statuses_data',
            'label' => $this->trans('Statuses')
        ]));

        $statusesData->addChild($builder->getElement('multi_select', [
            'name'        => 'statuses',
            'label'       => $this->trans('Statuses'),
            'options'     => $this->get('product_status.repository')->getCollectionToSelect(),
            'transformer' => new CollectionToArrayTransformer($this->get('product_status.repository'))
        ]));

        $attributesData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'attributes_data',
            'label' => $this->trans('Attributes')
        ]));

        $attributesData->addChild($builder->getElement('product_variants_editor', [
            'name'               => 'attributes',
            'label'              => $this->trans('Attributes'),
            'price_field'        => $priceField,
            'vat_field'          => $vatField,
            'vat_values'         => $vatValues,
            'category_field'     => $categoriesField,
            'availability_field' => $availabilityField,
            'transformer'        => new ProductAttributeCollectionToArrayTransformer($this->get('product_attribute.repository'))
        ]));

        $form->addFilter('trim');
        $form->addFilter('secure');

        return $form;
    }
}
