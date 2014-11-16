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
use WellCommerce\Bundle\FormBundle\Form\FormInterface;

/**
 * Class ProductStatusForm
 *
 * @package WellCommerce\Bundle\ProductBundle\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form = $builder->init($options);

        $mainData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('fieldset.main.label')
        ]));

        $languageData = $mainData->addChild($builder->getElement('fieldset_language', [
            'name'  => 'translations',
            'label' => $this->trans('fieldset.translations.label')
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('product_status.name.label'),
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'    => 'cssClass',
            'label'   => $this->trans('product_status.css_class.label'),
            'comment' => $this->trans('product_status.css_class.comment'),
        ]));

        $form->addFilter('no_code');
        $form->addFilter('trim');
        $form->addFilter('secure');

        return $form;
    }
}
