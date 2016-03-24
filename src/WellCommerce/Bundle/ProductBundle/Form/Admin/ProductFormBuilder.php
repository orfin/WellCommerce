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
namespace WellCommerce\Bundle\ProductBundle\Form\Admin;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Component\Form\DataTransformer\DateTransformer;
use WellCommerce\Component\Form\Elements\ElementInterface;
use WellCommerce\Component\Form\Elements\FormInterface;

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
        $currencies = $this->get('currency.dataset.admin')->getResult('select', ['order_by' => 'code'], [
            'label_column' => 'code',
            'value_column' => 'code'
        ]);

        $vatValues = $this->get('tax.dataset.admin')->getResult('select', ['order_by' => 'value']);

        $mainData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'main_data',
            'label' => $this->trans('common.fieldset.general')
        ]));

        $languageData = $mainData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('locale.label.language'),
            'transformer' => $this->getRepositoryTransformer('translation', $this->get('product.repository'))
        ]));

        $name = $languageData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('common.label.name'),
            'rules' => [
                $this->getRule('required')
            ],
        ]));

        $languageData->addChild($this->getElement('slug_field', [
            'name'            => 'slug',
            'label'           => $this->trans('product.label.slug'),
            'name_field'      => $name,
            'generate_route'  => 'admin.routing.generate',
            'translatable_id' => $this->getRequestHelper()->getAttributesBagParam('id'),
            'rules'           => [
                $this->getRule('required')
            ],
        ]));

        $mainData->addChild($this->getElement('checkbox', [
            'name'    => 'enabled',
            'label'   => $this->trans('common.label.enabled'),
            'comment' => $this->trans('product.comment.enabled'),
        ]));

        $mainData->addChild($this->getElement('text_field', [
            'name'  => 'hierarchy',
            'label' => $this->trans('common.label.hierarchy'),
            'rules' => [
                $this->getRule('required')
            ],
        ]));

        $descriptionData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'description_data',
            'label' => $this->trans('common.fieldset.description')
        ]));

        $languageData = $descriptionData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('locale.label.translations'),
            'transformer' => $this->getRepositoryTransformer('translation', $this->get('product.repository'))
        ]));

        $languageData->addChild($this->getElement('rich_text_editor', [
            'name'  => 'shortDescription',
            'label' => $this->trans('common.label.short_description')
        ]));

        $languageData->addChild($this->getElement('rich_text_editor', [
            'name'  => 'description',
            'label' => $this->trans('common.label.description'),
        ]));

        $mainData->addChild($this->getElement('text_field', [
            'name'  => 'sku',
            'label' => $this->trans('common.label.sku'),
            'rules' => [
                $this->getRule('required')
            ],
        ]));

        $mainData->addChild($this->getElement('select', [
            'name'        => 'producer',
            'label'       => $this->trans('common.label.producer'),
            'options'     => $this->get('producer.dataset.admin')->getResult('select'),
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('producer.repository')),
        ]));

        $this->addMetadataFieldset($form, $this->get('product.repository'));

        $categoryPane = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'category_pane',
            'label' => $this->trans('common.fieldset.categories')
        ]));

        $categoriesField = $categoryPane->addChild($this->getElement('tree', [
            'name'        => 'categories',
            'label'       => $this->trans('common.label.categories'),
            'choosable'   => false,
            'selectable'  => true,
            'sortable'    => false,
            'clickable'   => false,
            'items'       => $this->get('category.dataset.admin')->getResult('flat_tree'),
            'transformer' => $this->getRepositoryTransformer('collection', $this->get('category.repository'))
        ]));

        $pricePane = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'price_pane',
            'label' => $this->trans('common.fieldset.prices')
        ]));

        $buyPriceSettings = $pricePane->addChild($this->getElement('nested_fieldset', [
            'name'  => 'buy_price_settings',
            'label' => $this->trans('product.label.buy_price.settings'),
            'class' => 'priceGroup'
        ]));

        $buyPriceSettings->addChild($this->getElement('select', [
            'name'    => 'buyPrice.currency',
            'label'   => $this->trans('common.label.currency'),
            'options' => $currencies,
        ]));

        $buyPriceTax = $buyPriceSettings->addChild($this->getElement('select', [
            'name'            => 'buyPriceTax',
            'label'           => $this->trans('common.label.tax'),
            'options'         => $vatValues,
            'addable'         => true,
            'onAdd'           => 'onTaxAdd',
            'add_item_prompt' => $this->trans('product.label.add_tax_prompt'),
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
            'label'   => $this->trans('common.label.currency'),
            'options' => $currencies,
        ]));

        $sellPriceTax = $sellPriceSettings->addChild($this->getElement('select', [
            'name'            => 'sellPriceTax',
            'label'           => $this->trans('common.label.tax'),
            'options'         => $vatValues,
            'addable'         => true,
            'onAdd'           => 'onTaxAdd',
            'add_item_prompt' => $this->trans('product.label.add_tax_prompt'),
            'transformer'     => $this->getRepositoryTransformer('entity', $this->get('tax.repository'))
        ]));

        $sellPriceAmount = $sellPriceSettings->addChild($this->getElement('price_editor', [
            'name'      => 'sellPrice.grossAmount',
            'label'     => $this->trans('product.label.sell_price.gross_amount'),
            'filters'   => [
                $this->getFilter('comma_to_dot_changer'),
            ],
            'vat_field' => $sellPriceTax
        ]));

        $sellPriceSettings->addChild($this->getElement('price_editor', [
            'name'      => 'sellPrice.discountedGrossAmount',
            'label'     => $this->trans('common.label.discounted_price'),
            'filters'   => [
                $this->getFilter('comma_to_dot_changer'),
            ],
            'vat_field' => $sellPriceTax
        ]));

        $sellPriceSettings->addChild($this->getElement('date', [
            'name'        => 'sellPrice.validFrom',
            'label'       => $this->trans('common.label.valid_from'),
            'transformer' => new DateTransformer('m/d/Y'),
        ]));

        $sellPriceSettings->addChild($this->getElement('date', [
            'name'        => 'sellPrice.validTo',
            'label'       => $this->trans('common.label.valid_to'),
            'transformer' => new DateTransformer('m/d/Y')
        ]));

        $stockData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'stock_data',
            'label' => $this->trans('product.form.fieldset.stock')
        ]));

        $stockData->addChild($this->getElement('text_field', [
            'name'   => 'stock',
            'label'  => $this->trans('common.label.stock'),
            'suffix' => $this->trans('product.label.pcs'),
            'rules'  => [
                $this->getRule('required')
            ],
        ]));

        $stockData->addChild($this->getElement('checkbox', [
            'name'    => 'trackStock',
            'label'   => $this->trans('product.label.track_stock'),
            'comment' => $this->trans('product.comment.track_stock'),
        ]));

        $stockData->addChild($this->getElement('select', [
            'name'        => 'unit',
            'label'       => $this->trans('product.label.unit'),
            'options'     => $this->get('unit.dataset.admin')->getResult('select'),
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('unit.repository'))
        ]));

        $stockData->addChild($this->getElement('text_field', [
            'name'    => 'weight',
            'label'   => $this->trans('common.label.dimension.weight'),
            'filters' => [
                $this->getFilter('comma_to_dot_changer'),
            ],
            'rules'   => [
                $this->getRule('required')
            ],
        ]));

        $stockData->addChild($this->getElement('text_field', [
            'name'    => 'dimension.width',
            'label'   => $this->trans('common.label.dimension.width'),
            'filters' => [
                $this->getFilter('comma_to_dot_changer'),
            ],
        ]));

        $stockData->addChild($this->getElement('text_field', [
            'name'    => 'dimension.height',
            'label'   => $this->trans('common.label.dimension.height'),
            'filters' => [
                $this->getFilter('comma_to_dot_changer'),
            ],
        ]));

        $stockData->addChild($this->getElement('text_field', [
            'name'    => 'dimension.depth',
            'label'   => $this->trans('common.label.dimension.depth'),
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
            'rules'   => [
                $this->getRule('required')
            ],
        ]));

        $availabilityField = $stockData->addChild($this->getElement('select', [
            'name'        => 'availability',
            'label'       => $this->trans('product.label.availability'),
            'options'     => $this->get('availability.dataset.admin')->getResult('select'),
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('availability.repository'))
        ]));

        $mediaData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'media_data',
            'label' => $this->trans('product.form.fieldset.photos')
        ]));

        $mediaData->addChild($this->getElement('image', [
            'name'         => 'productPhotos',
            'label'        => $this->trans('product.label.photos'),
            'load_route'   => $this->getRouterHelper()->generateUrl('admin.media.grid'),
            'upload_url'   => $this->getRouterHelper()->generateUrl('admin.media.add'),
            'repeat_min'   => 0,
            'repeat_max'   => ElementInterface::INFINITE,
            'transformer'  => $this->getRepositoryTransformer('product_photo_collection', $this->get('media.repository')),
            'session_id'   => $this->getRequestHelper()->getSessionId(),
            'session_name' => $this->getRequestHelper()->getSessionName(),
        ]));

        $statusesData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'statuses_data',
            'label' => $this->trans('product.form.fieldset.statuses')
        ]));

        $statusesData->addChild($this->getElement('multi_select', [
            'name'        => 'statuses',
            'label'       => $this->trans('product.label.statuses'),
            'options'     => $this->get('product_status.dataset.admin')->getResult('select'),
            'transformer' => $this->getRepositoryTransformer('collection', $this->get('product_status.repository'))
        ]));

        if ($this->getAttributeGroups()->count()) {
            $attributesData = $form->addChild($this->getElement('nested_fieldset', [
                'name'  => 'attributes_data',
                'label' => $this->trans('product.form.fieldset.variants')
            ]));

            $attributesData->addChild($this->getElement('variant_editor', [
                'name'               => 'variants',
                'label'              => $this->trans('product.label.variants'),
                'suffixes'           => ['+', '-', '%'],
                'price_field'        => $sellPriceAmount,
                'vat_field'          => $sellPriceTax,
                'vat_values'         => $vatValues,
                'category_field'     => $categoriesField,
                'availability_field' => $availabilityField,
                'availability'       => $availabilityField->getOption('options'),
                'transformer'        => $this->getRepositoryTransformer('variant_collection', $this->get('variant.repository'))
            ]));
        }

        $this->addShopsFieldset($form);

        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }

    protected function getAttributeGroups() : Collection
    {
        return $this->get('attribute_group.repository')->matching(new Criteria());
    }
}
