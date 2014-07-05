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
namespace WellCommerce\Plugin\Tax\Form;

use WellCommerce\Core\Component\Form\AbstractForm;
use WellCommerce\Core\Component\Form\FormBuilderInterface;
use WellCommerce\Core\Component\Form\FormInterface;
use WellCommerce\Plugin\Tax\Model\Tax;

/**
 * Class TaxForm
 *
 * @package WellCommerce\Plugin\Tax\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TaxForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form = $builder->addForm($options);

        $requiredData = $form->addChild($builder->addFieldset([
            'name'  => 'required_data',
            'label' => $this->trans('Basic settings')
        ]));

        $languageData = $requiredData->addChild($builder->addFieldsetLanguage([
            'name'  => 'language_data',
            'label' => $this->trans('Language settings')
        ]));

        $languageData->addChild($builder->addTextField([
            'name'  => 'name',
            'label' => $this->trans('Name'),
            'rules' => [
                $builder->addRuleRequired($this->trans('Name is required')),
                $builder->addRuleUnique($this->trans('Tax rate already exists'),
                    [
                        'table'   => 'tax_translation',
                        'column'  => 'name',
                        'exclude' => [
                            'column' => 'tax_id',
                            'values' => $this->getParam('id')
                        ]
                    ]
                )
            ]
        ]));

        $requiredData->addChild($builder->addTextField([
            'name'    => 'value',
            'label'   => $this->trans('Tax value'),
            'comment' => $this->trans('Tax value given in %'),
            'rules'   => [
                $builder->addRuleRequired($this->trans('Tax value is required')),
                $builder->addRuleUnique($this->trans('Tax value already exists'),
                    [
                        'table'   => 'tax',
                        'column'  => 'value',
                        'exclude' => [
                            'column' => 'id',
                            'values' => $this->getParam('id')
                        ]
                    ]
                )
            ],
            'suffix'  => '%',
            'filters' => [
                $builder->addFilterCommaToDotChanger()
            ]
        ]));

        $form->addFilters([
            $builder->addFilterNoCode(),
            $builder->addFilterTrim(),
            $builder->addFilterSecure()
        ]);

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function prepareData(Tax $tax)
    {
        $populateData = [];
        $accessor     = $this->getPropertyAccessor();
        $languageData = $tax->translation->getTranslations();

        $accessor->setValue($populateData, '[required_data]', [
            'value'         => $tax->value,
            'language_data' => $languageData
        ]);

        return $populateData;
    }
}
