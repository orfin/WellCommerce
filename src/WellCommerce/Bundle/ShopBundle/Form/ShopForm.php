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
namespace WellCommerce\Bundle\ShopBundle\Form;

use WellCommerce\Bundle\FormBundle\Form\AbstractForm;
use WellCommerce\Bundle\FormBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\FormBundle\Form\DataTransformer\CollectionToArrayTransformer;
use WellCommerce\Bundle\FormBundle\Form\DataTransformer\EntityToIdentifierTransformer;
use WellCommerce\Bundle\FormBundle\Form\FormInterface;

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
        $form = $builder->init($options);

        $requiredData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('form.required_data')
        ]));

        $languageData = $requiredData->addChild($builder->getElement('fieldset_language', [
            'name'  => 'translations',
            'label' => $this->trans('Translations'),
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('shop.name'),
            'rules' => [
                $builder->getRule('required', [
                    'message' => $this->trans('Name is required')
                ])
            ]
        ]));

        $requiredData->addChild($builder->getElement('checkbox', [
            'name'    => 'enabled',
            'label'   => $this->trans('Enabled'),
            'comment' => $this->trans('Only logged administrators can access shop'),
            'default' => 1
        ]));

        $requiredData->addChild($builder->getElement('select', [
            'name'        => 'company',
            'label'       => $this->trans('shop.company'),
            'options'     => $this->get('company.repository')->getCollectionToSelect(),
            'transformer' => new EntityToIdentifierTransformer($this->get('company.repository'))
        ]));

        $requiredData->addChild($builder->getElement('select', [
            'name'        => 'layoutTheme',
            'label'       => $this->trans('Theme'),
            'comment'     => $this->trans('Choose default shop theme'),
            'options'     => $this->get('theme.repository')->getCollectionToSelect(),
            'transformer' => new EntityToIdentifierTransformer($this->get('theme.repository'))
        ]));

        $localizationData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'localization_data',
            'label' => $this->trans('localization.data')
        ]));

        $localizationData->addChild($builder->getElement('multi_select', [
            'name'        => 'locales',
            'label'       => $this->trans('Available locales'),
            'options'     => $this->get('locale.repository')->getLocalesToSelect(),
            'transformer' => new CollectionToArrayTransformer($this->get('locale.repository'))
        ]));

        $localizationData->addChild($builder->getElement('multi_select', [
            'name'        => 'currencies',
            'label'       => $this->trans('Available currencies'),
            'options'     => $this->get('currency.repository')->getCollectionToSelect('code'),
            'transformer' => new CollectionToArrayTransformer($this->get('currency.repository'))
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

        $shopData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'payment_method_data',
            'label' => $this->trans('Payment methods')
        ]));

        $shopData->addChild($builder->getElement('multi_select', [
            'name'        => 'paymentMethods',
            'label'       => $this->trans('Payment methods'),
            'options'     => $this->get('payment_method.repository')->getCollectionToSelect(),
            'transformer' => new CollectionToArrayTransformer($this->get('payment_method.repository'))
        ]));

        $form->addFilter('no_code');
        $form->addFilter('trim');
        $form->addFilter('secure');

        return $form;
    }
}
