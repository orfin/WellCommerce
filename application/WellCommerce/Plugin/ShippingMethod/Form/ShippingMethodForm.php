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
namespace WellCommerce\Plugin\ShippingMethod\Form;

use WellCommerce\Core\Component\Form\AbstractForm;
use WellCommerce\Core\Component\Form\FormBuilderInterface;
use WellCommerce\Core\Component\Form\FormInterface;
use WellCommerce\Core\Component\Form\Option;
use WellCommerce\Plugin\ShippingMethod\Model\ShippingMethod;

/**
 * Class ShippingMethodForm
 *
 * @package WellCommerce\Plugin\ShippingMethod\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingMethodForm extends AbstractForm implements FormInterface
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
            'label'     => $this->trans('Translations'),
            'languages' => $this->getLanguages()
        ]));

        $languageData->addChild($builder->addTextField([
            'name'  => 'name',
            'label' => $this->trans('Name'),
            'rules' => [
                $builder->addRuleRequired($this->trans('Name is required')),
                $builder->addRuleLanguageUnique($this->trans('Name already exists'),
                    [
                        'table'   => 'shipping_method_translation',
                        'column'  => 'name',
                        'exclude' => [
                            'column' => 'shipping_method_id',
                            'values' => $this->getParam('id')
                        ]
                    ]
                )
            ]
        ]));

        $requiredData->addChild($builder->addTip([
            'tip' => '<p>' . $this->trans('Choose type of costs calculation. Every shipping method may have different settings.') . '</p>'
        ]));

        $requiredData->addChild($builder->addSelect([
            'name'    => 'type',
            'label'   => $this->trans('Type of costs calculation'),
            'options' => [],
        ]));

        $requiredData->addChild($builder->addCheckBox([
            'name'    => 'enabled',
            'label'   => $this->trans('Enabled'),
            'comment' => $this->trans('Only enabled shipping methods are visible in shop'),
            'default' => '1'
        ]));

        $requiredData->addChild($builder->addTextField([
            'name'    => 'hierarchy',
            'label'   => $this->trans('Hierarchy'),
            'comment' => $this->trans('Hierarchy uses ascending order'),
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
     * Prepares form data using retrieved model
     *
     * @param ShippingMethod $shippingMethod Model
     *
     * @return array
     */
    public function prepareData(ShippingMethod $shippingMethod)
    {
        $formData     = [];
        $accessor     = $this->getPropertyAccessor();
        $languageData = $shippingMethod->translation->getTranslations();

        $accessor->setValue($formData, '[required_data]', [
            'language_data' => $languageData,
            'type'          => $shippingMethod->type,
            'show_header'   => $shippingMethod->show_header,
            'visibility'    => $shippingMethod->visibility,
        ]);

        $accessor->setValue($formData, '[' . $shippingMethod->type . ']', $shippingMethod->settings);

        return $formData;
    }
}
