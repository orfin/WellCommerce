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

use WellCommerce\Bundle\CoreBundle\Form\AbstractForm;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\CollectionToArrayTransformer;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\EntityToIdentifierTransformer;
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;
use WellCommerce\Bundle\MediaBundle\Form\DataTransformer\MediaCollectionToArrayTransformer;
use WellCommerce\Bundle\MediaBundle\Form\DataTransformer\MediaEntityToIdentifierTransformer;

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
        $form = $builder->init($options);

        $requiredData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('Required data')
        ]));

        $languageData = $requiredData->addChild($builder->getElement('fieldset_language', [
            'name'  => 'translations',
            'label' => $this->trans('Language data')
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('product.name'),
            'rules' => [
                $builder->getRule('required', [
                    'message' => $this->trans('Name is required')
                ]),
            ]
        ]));

        $requiredData->addChild($builder->getElement('checkbox', [
            'name'    => 'enabled',
            'label'   => $this->trans('Enabled'),
            'comment' => $this->trans('Only enabled products are visible in shops')
        ]));

        $requiredData->addChild($builder->getElement('select', [
            'name'        => 'producer',
            'label'       => $this->trans('Producer'),
            'options'     => $this->get('producer.repository')->getCollectionToSelect(),
            'transformer' => new EntityToIdentifierTransformer($this->get('producer.repository'))
        ]));

        $metaData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'meta_data',
            'label' => $this->trans('Meta settings')
        ]));

        $languageData = $metaData->addChild($builder->getElement('fieldset_language', [
            'name'  => 'translations',
            'label' => $this->trans('Translations'),
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'metaTitle',
            'label' => $this->trans('Title')
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'metaKeywords',
            'label' => $this->trans('Keywords'),
        ]));

        $languageData->addChild($builder->getElement('text_area', [
            'name'  => 'metaDescription',
            'label' => $this->trans('Description'),
        ]));

        $categoryPane = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'category_pane',
            'label' => $this->trans('Categories')
        ]));

        $categoryPane->addChild($builder->getElement('tree', [
            'name'        => 'categories',
            'label'       => $this->trans('Categories'),
            'choosable'   => false,
            'selectable'  => true,
            'sortable'    => false,
            'clickable'   => false,
            'items'       => $this->get('category.repository')->getTreeItems(),
            'transformer' => new CollectionToArrayTransformer($this->get('category.repository'))
        ]));

        $pricePane = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'price_pane',
            'label' => $this->trans('Price settings')
        ]));

        $currencies = $this->get('currency.repository')->getCollectionToSelect('code');

        $vat = $pricePane->addChild($builder->getElement('select', [
            'name'        => 'taxId',
            'label'       => $this->trans('Tax'),
            'options'     => $this->get('tax.repository')->getCollectionToSelect(),
            'transformer' => new EntityToIdentifierTransformer($this->get('tax.repository'))
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
            'rules'     => [
                $builder->getRule('required', [
                    'message' => $this->trans('Buy price is required')
                ]),
            ],
            'filters'   => [
                $builder->getFilter('comma_to_dot_changer')
            ],
            'vat_field' => $vat,
        ]));

        $standardPrice = $pricePane->addChild($builder->getElement('fieldset', [
            'name'  => 'standard_price',
            'label' => $this->trans('Standard sell price'),
            'class' => 'priceGroup'
        ]));

        $standardPrice->addChild($builder->getElement('price', [
            'name'      => 'sellPrice',
            'label'     => $this->trans('Sell price'),
            'rules'     => [
                $builder->getRule('required', [
                    'message' => $this->trans('Sell price is required')
                ])
            ],
            'filters'   => [
                $builder->getFilter('comma_to_dot_changer')
            ],
            'vat_field' => $vat,
        ]));

        $stockData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'stock_data',
            'label' => $this->trans('Stock settings')
        ]));

        $stockData->addChild($builder->getElement('text_field', [
            'name'    => 'stock',
            'label'   => $this->trans('Stock'),
            'rules'   => [
                $builder->getRule('required', [
                    'message' => $this->trans('Stock is required')
                ])
            ],
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
            'rules'   => [
                $builder->getRule('required', [
                    'message' => $this->trans('Weight is required')
                ])
            ],
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
            'rules'   => [
                $builder->getRule('required', [
                    'message' => $this->trans('Package size is required')
                ])
            ],
            'filters' => [
                $builder->getFilter('comma_to_dot_changer')
            ],
            'default' => 1
        ]));

        $stockData->addChild($builder->getElement('select', [
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

        $shopData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'shop_data',
            'label' => $this->trans('Shops')
        ]));

        $shopData->addChild($builder->getElement('multi_select', [
            'name'        => 'shops',
            'label'       => $this->trans('shops'),
            'options'     => $this->get('shop.repository')->getCollectionToSelect(),
            'transformer' => new CollectionToArrayTransformer($this->get('shop.repository'))
        ]));

        $form->addFilter('no_code');
        $form->addFilter('trim');
        $form->addFilter('secure');

        return $form;
    }
}
