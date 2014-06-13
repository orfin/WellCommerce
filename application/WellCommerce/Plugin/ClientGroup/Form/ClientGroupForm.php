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
namespace WellCommerce\Plugin\ClientGroup\Form;

use WellCommerce\Core\Component\Form\AbstractForm;
use WellCommerce\Core\Component\Form\FormBuilder;
use WellCommerce\Core\Component\Form\FormInterface;
use WellCommerce\Core\Component\Model\ModelInterface;
use WellCommerce\Plugin\ClientGroup\Event\ClientGroupFormEvent;
use WellCommerce\Plugin\ClientGroup\Model\ClientGroup;

/**
 * Class ClientGroupForm
 *
 * @package WellCommerce\Plugin\ClientGroup\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientGroupForm extends AbstractForm implements FormInterface
{
    /**
     * Builds form instance to add/edit ClientGroup model
     *
     * @param FormBuilder $builder FormBuilder instance
     * @param array       $options Form options
     *
     * @return mixed|\WellCommerce\Core\Component\Form\Elements\Form
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $form = $builder->addForm($options);

        $requiredData = $form->addChild($builder->addFieldset([
            'name'  => 'required_data',
            'label' => $this->trans('Required data')
        ]));

        $requiredData->addChild($builder->addTextField([
            'name'    => 'discount',
            'label'   => $this->trans('Discount'),
            'comment' => $this->trans('Discount for particular client group'),
            'suffix'  => '%',
            'rules'   => [
                $builder->addRuleCustom($this->trans('Discount must be between 0-100'), function ($value) {
                    return ($value >= 0 && $value <= 100);
                })
            ],
            'filters' => [
                $builder->addFilterCommaToDotChanger()
            ],
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
                        'table'   => 'client_group_translation',
                        'column'  => 'name',
                        'exclude' => [
                            'column' => 'client_group_id',
                            'values' => $this->getParam('id')
                        ]
                    ]
                )
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
     * Prepares model data to populate the ClientGroup form
     *
     * @param ClientGroup $model
     *
     * @return array
     */
    public function prepareData(ClientGroup $clientGroup)
    {
        $formData     = [];
        $accessor     = $this->getPropertyAccessor();
        $languageData = $clientGroup->translation->getTranslations();

        $accessor->setValue($formData, '[required_data]', [
            'discount'      => $clientGroup->discount,
            'language_data' => $languageData,
        ]);

        return $formData;
    }
}
