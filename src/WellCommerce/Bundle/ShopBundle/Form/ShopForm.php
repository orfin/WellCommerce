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

use WellCommerce\Bundle\CompanyBundle\Form\DataTransformer\CompanyToNumberTransformer;
use WellCommerce\Bundle\CoreBundle\Form\AbstractForm;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\CollectionToArrayTransformer;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\EntityToIdentifierTransformer;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;

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

        $requiredData->addChild($builder->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('shop.name'),
            'rules' => [
                $builder->getRule('required', [
                    'message' => $this->trans('Name is required')
                ])
            ]
        ]));

        $requiredData->addChild($builder->getElement('select', [
            'name'        => 'company',
            'label'       => $this->trans('shop.company'),
            'options'     => $this->get('company.repository')->getCollectionToSelect(),
            'transformer' => new EntityToIdentifierTransformer($this->get('company.repository'))
        ]));

        $localizationData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'localization_data',
            'label' => $this->trans('localization.data')
        ]));

        $localizationData->addChild($builder->getElement('multi_select', [
            'name'        => 'availableLocales',
            'label'       => $this->trans('Available locales'),
            'options'     => $this->get('locale.repository')->getLocalesToSelect(),
            'transformer' => new CollectionToArrayTransformer($this->get('locale.repository'))
        ]));

        $form->addFilter('no_code');
        $form->addFilter('trim');
        $form->addFilter('secure');

        return $form;
    }
}
