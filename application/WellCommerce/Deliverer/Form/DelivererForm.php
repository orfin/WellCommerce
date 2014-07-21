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
namespace WellCommerce\Deliverer\Form;

use WellCommerce\Core\Form\AbstractForm;
use WellCommerce\Core\Form\Builder\FormBuilderInterface;
use WellCommerce\Core\Form\FormInterface;
use WellCommerce\Deliverer\Model\Deliverer;

/**
 * Class DelivererForm
 *
 * @package WellCommerce\Deliverer\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DelivererForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form = $builder->addForm([
            'name' => 'deliverer'
        ]);

        $requiredData = $form->addChild($builder->addFieldset([
            'name'  => 'required_data',
            'label' => $this->trans('Basic settings')
        ]));

        $languageData = $requiredData->addChild($builder->addFieldsetLanguage([
            'name'      => 'language_data',
            'label'     => $this->trans('Language settings'),
            'languages' => $this->getLanguages()
        ]));

        $languageData->addChild($builder->addTextField([
            'name'  => 'name',
            'label' => $this->trans('Name'),
            'rules' => [
                $builder->addRuleRequired($this->trans('Name is required')),
                $builder->addRuleUnique($this->trans('Deliverer already exists'),
                    [
                        'table'   => 'deliverer_translation',
                        'column'  => 'name',
                        'exclude' => [
                            'column' => 'deliverer_id',
                            'values' => $this->getParam('id')
                        ]
                    ]
                )
            ]
        ]));

        $form->addFilters([
            $builder->addFilterTrim(),
            $builder->addFilterSecure(),
            $builder->addFilterNoCode()
        ]);

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function prepareData(Deliverer $deliverer)
    {
        $populateData = [];
        $accessor     = $this->getPropertyAccessor();
        $languageData = $deliverer->translation->getTranslations();

        $accessor->setValue($populateData, '[required_data]', [
            'language_data' => $languageData
        ]);

        return $populateData;
    }
}
