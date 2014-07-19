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
namespace WellCommerce\Product\Form;

use WellCommerce\Core\Component\Form\AbstractForm;
use WellCommerce\Core\Component\Form\Elements\Tip;
use WellCommerce\Core\Component\Form\FormBuilderInterface;
use WellCommerce\Core\Component\Form\FormInterface;
use WellCommerce\Product\Model\Product;

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
        $currencies = $this->get('currency.repository')->getAllCurrencyToSelect();

        $this->getXajaxManager()->registerFunctions([
            'AddProducer'  => [$this->get('producer.repository'), 'addSimpleProducer'],
            'AddDeliverer' => [$this->get('deliverer.repository'), 'addSimpleDeliverer'],
            'AddTax'       => [$this->get('tax.repository'), 'addSimpleTax']
        ]);

        $form = $builder->addForm($options);

        $basicPane = $form->addChild($builder->addFieldset([
            'name'  => 'basic_pane',
            'label' => $this->trans('Basic settings')
        ]));

        $basicLanguageData = $basicPane->addChild($builder->addFieldsetLanguage([
            'name'  => 'language_data',
            'label' => $this->trans('Translations'),
        ]));

        $basicLanguageData->addChild($builder->addTextField([
            'name'  => 'name',
            'label' => $this->trans('Name'),
            'rules' => [
                $builder->addRuleRequired($this->trans('Name is required'))
            ]
        ]));

        $basicLanguageData->addChild($builder->addTextField([
            'name'  => 'slug',
            'label' => $this->trans('Slug'),
            'rules' => [
                $builder->addRuleRequired($this->trans('Slug is required')),
                $builder->addRuleUnique($this->trans('Slug already exists'),
                    [
                        'table'   => 'product_translation',
                        'column'  => 'slug',
                        'exclude' => [
                            'column' => 'product_id',
                            'values' => $this->getParam('id')
                        ]
                    ]
                ),
                $builder->addRuleFormat($this->trans('Only alphanumeric characters are allowed'), '/^[A-Za-z0-9-_\",\'\s]+$/')
            ]
        ]));

        $basicPane->addChild($builder->addCheckbox([
            'name'    => 'enabled',
            'label'   => $this->trans('Enabled'),
            'default' => '0'
        ]));

        $basicPane->addChild($builder->addTextField([
            'name'  => 'ean',
            'label' => $this->trans('EAN')
        ]));

        $basicPane->addChild($builder->addTextField([
            'name'  => 'sku',
            'label' => $this->trans('SKU')
        ]));

        $basicPane->addChild($builder->addSelect([
            'name'            => 'producer_id',
            'label'           => $this->trans('Producer'),
            'addable'         => true,
            'onAdd'           => 'xajax_AddProducer',
            'add_item_prompt' => $this->trans('Enter producer name'),
            'options'         => $builder->makeOptions($this->get('producer.repository')->getAllProducerToSelect(), true)
        ]));

        $basicPane->addChild($builder->addMultiSelect([
            'name'            => 'deliverers',
            'label'           => $this->trans('Deliverers'),
            'addable'         => true,
            'onAdd'           => 'xajax_AddDeliverer',
            'add_item_prompt' => $this->trans('Enter deliverer name'),
            'options'         => $builder->makeOptions($this->get('deliverer.repository')->getAllDelivererToSelect())
        ]));

        $metaData = $form->addChild($builder->addFieldset([
            'name'  => 'meta_data',
            'label' => $this->trans('Meta settings')
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

        $stockPane = $form->addChild($builder->addFieldset([
            'name'  => 'stock_pane',
            'label' => $this->trans('Stock settings')
        ]));

        $stockPane->addChild($builder->addTextField([
            'name'    => 'stock',
            'label'   => $this->trans('Stock'),
            'rules'   => [
                $builder->addRuleRequired($this->trans('Stock is required')),
                $builder->addRuleFormat($this->trans('Only numeric characters are allowed'), '/[0-9]{1,}/')
            ],
            'suffix'  => $this->trans('pcs'),
            'default' => 0
        ]));

        $stockPane->addChild($builder->addCheckbox([
            'name'  => 'track_stock',
            'label' => $this->trans('Track stock')
        ]));

        $categoryPane = $form->addChild($builder->addFieldset([
            'name'  => 'category_pane',
            'label' => $this->trans('Categories')
        ]));

        $categoryPane->addChild($builder->addTree([
            'name'       => 'category',
            'label'      => $this->trans('Categories'),
            'choosable'  => false,
            'selectable' => true,
            'sortable'   => false,
            'clickable'  => false,
            'items'      => $this->get('category.repository')->getCategoriesTree()
        ]));

        $pricePane = $form->addChild($builder->addFieldset([
            'name'  => 'price_pane',
            'label' => $this->trans('Price settings')
        ]));

        $vat = $pricePane->addChild($builder->addSelect([
            'name'            => 'tax_id',
            'label'           => $this->trans('Tax'),
            'options'         => $builder->makeOptions($this->get('tax.repository')->getAllTaxToSelect(), true),
            'addable'         => true,
            'onAdd'           => 'xajax_AddTax',
            'add_item_prompt' => $this->trans('Enter tax value')
        ]));


        $pricePane->addChild($builder->addSelect([
            'name'    => 'sell_currency_id',
            'label'   => $this->trans('Currency for sell prices'),
            'options' => $builder->makeOptions($currencies)
        ]));

        $pricePane->addChild($builder->addSelect([
            'name'    => 'buy_currency_id',
            'label'   => $this->trans('Currency for buy prices'),
            'options' => $builder->makeOptions($currencies)
        ]));

        $pricePane->addChild($builder->addPrice([
            'name'      => 'buy_price',
            'label'     => $this->trans('Buy price'),
            'rules'     => [
                $builder->addRuleRequired($this->trans('Buy price is required')),
                $builder->addRuleFormat($this->trans('Only numeric characters are allowed'), '/[0-9]{1,}/')
            ],
            'filters'   => [
                $builder->addFilterCommaToDotChanger()
            ],
            'vat_field' => $vat
        ]));

        $standardPrice = $pricePane->addChild($builder->addFieldset([
            'name'  => 'standard_price',
            'label' => $this->trans('Standard sell price'),
            'class' => 'priceGroup'
        ]));

        $standardPrice->addChild($builder->addPrice([
            'name'      => 'sell_price',
            'label'     => $this->trans('Sell price'),
            'rules'     => [
                $builder->addRuleRequired($this->trans('Sell price is required')),
                $builder->addRuleFormat($this->trans('Only numeric characters are allowed'), '/[0-9]{1,}/')
            ],
            'filters'   => [
                $builder->addFilterCommaToDotChanger()
            ],
            'vat_field' => $vat
        ]));

        $measurementsPane = $form->addChild($builder->addFieldset([
            'name'  => 'measurements_pane',
            'label' => $this->trans('Measurements')
        ]));

        $measurementsPane->addChild($builder->addSelect([
            'name'    => 'unit_id',
            'label'   => $this->trans('Unit'),
            'options' => $builder->makeOptions($this->get('unit.repository')->getAllUnitToSelect())
        ]));

        $measurementsPane->addChild($builder->addTextField([
            'name'    => 'weight',
            'label'   => $this->trans('Weight'),
            'rules'   => [
                $builder->addRuleRequired($this->trans('Weight is required')),
                $builder->addRuleFormat($this->trans('Only numeric characters are allowed'), '/[0-9]{1,}/')
            ],
            'filters' => [
                $builder->addFilterCommaToDotChanger()
            ],
            'default' => 0
        ]));

        $measurementsPane->addChild($builder->addTextField([
            'name'    => 'width',
            'label'   => $this->trans('Width'),
            'filters' => [
                $builder->addFilterCommaToDotChanger()
            ]
        ]));

        $measurementsPane->addChild($builder->addTextField([
            'name'    => 'height',
            'label'   => $this->trans('Height'),
            'filters' => [
                $builder->addFilterCommaToDotChanger()
            ]
        ]));

        $measurementsPane->addChild($builder->addTextField([
            'name'    => 'depth',
            'label'   => $this->trans('Depth'),
            'filters' => [
                $builder->addFilterCommaToDotChanger()
            ]
        ]));

        $measurementsPane->addChild($builder->addTextField([
            'name'    => 'package_size',
            'label'   => $this->trans('Package size'),
            'rules'   => [
                $builder->addRuleRequired($this->trans('Package size is required')),
                $builder->addRuleFormat($this->trans('Only numeric characters are allowed'), '/[0-9]{1,}/')
            ],
            'filters' => [
                $builder->addFilterCommaToDotChanger()
            ],
            'default' => 1
        ]));

        $descriptionPane = $form->addChild($builder->addFieldset([
            'name'  => 'description_pane',
            'label' => $this->trans('Product descriptions')
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

        $descriptionLanguageData->addChild($builder->addRichTextEditor([
            'name'  => 'long_description',
            'label' => $this->trans('Long description'),
            'rows'  => 30
        ]));

        $photosPane = $form->addChild($builder->addFieldset([
            'name'  => 'photos_pane',
            'label' => $this->trans('Photos')
        ]));

        $photosPane->addChild($builder->addTip([
            'tip'       => '<p align="center">' . $this->trans('Please choose files from library or upload them from disk') . '</p>',
            'direction' => Tip::DOWN
        ]));

        $photosPane->addChild($builder->addImage([
            'name'       => 'photo',
            'label'      => $this->trans('Photos'),
            'upload_url' => $this->generateUrl('admin.file.add')
        ]));

        $shopData = $form->addChild($builder->addFieldset([
            'name'  => 'shop_data',
            'label' => $this->trans('Shops')
        ]));

        $shopData->addChild($builder->addShopSelector([
            'name'  => 'shops',
            'label' => $this->trans('Shops'),
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
    public function prepareData(Product $product)
    {
        $formData     = [];
        $accessor     = $this->getPropertyAccessor();
        $languageData = $product->translations->getTranslations();

        $accessor->setValue($formData, '[basic_pane]', [
            'language_data' => $languageData,
            'enabled'       => $product->enabled,
            'ean'           => $product->ean,
            'sku'           => $product->sku,
            'producer_id'   => $product->producer_id,
            'deliverers'    => $product->deliverer->getPrimaryKeys(),
        ]);

        $accessor->setValue($formData, '[stock_pane]', [
            'stock'       => $product->stock,
            'track_stock' => $product->track_stock,
        ]);

        $accessor->setValue($formData, '[category_pane]', [
            'category' => $product->category->getPrimaryKeys(),
        ]);

        $accessor->setValue($formData, '[description_data]', [
            'language_data' => $languageData
        ]);

        $accessor->setValue($formData, '[meta_data]', [
            'language_data' => $languageData
        ]);

        $accessor->setValue($formData, '[price_pane]', [
            'tax_id'           => $product->tax_id,
            'sell_currency_id' => $product->sell_currency_id,
            'buy_currency_id'  => $product->buy_currency_id,
            'buy_price'        => $product->buy_price,
            'standard_price'   => [
                'sell_price' => $product->sell_price,
            ]
        ]);

        $accessor->setValue($formData, '[measurements_pane]', [
            'weight'       => $product->weight,
            'width'        => $product->width,
            'height'       => $product->height,
            'depth'        => $product->depth,
            'unit_id'      => $product->unit_id,
            'package_size' => $product->package_size,

        ]);

        $accessor->setValue($formData, '[photos_pane]', [
            'photo' => [
                'photos'        => $product->photos->getPrimaryKeys(),
                'main_photo_id' => $product->photo_id
            ]
        ]);

        $accessor->setValue($formData, '[shop_data]', [
            'shops' => $product->shop->getPrimaryKeys()
        ]);

        return $formData;
    }
}
