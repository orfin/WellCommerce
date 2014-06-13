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
namespace WellCommerce\Plugin\Availability\Form;

use WellCommerce\Core\Component\Form\AbstractForm;
use WellCommerce\Core\Component\Form\FormBuilder;
use WellCommerce\Core\Component\Form\FormInterface;
use WellCommerce\Core\Component\Model\ModelInterface;
use WellCommerce\Plugin\Availability\Model\Availability;

/**
 * Class AvailabilityForm
 *
 * @package WellCommerce\Plugin\Availability\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
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
                        'table'   => 'availability_translation',
                        'column'  => 'name',
                        'exclude' => [
                            'column' => 'availability_id',
                            'values' => $this->getParam('id')
                        ]
                    ]
                )
            ]
        ]));

        $languageData->addChild($builder->addTextArea([
            'name'  => 'description',
            'label' => $this->trans('Description')
        ]));

        $form->addFilters([
            $builder->addFilterNoCode(),
            $builder->addFilterTrim(),
            $builder->addFilterSecure()
        ]);

        return $form;
    }

    /**
     * Prepares form data using retrieved model
     *
     * @param Availability $availability Model
     *
     * @return array
     */
    public function prepareData(Availability $availability)
    {
        $formData     = [];
        $accessor     = $this->getPropertyAccessor();
        $languageData = $availability->translation->getTranslations();

        $accessor->setValue($formData, '[required_data]', [
            'language_data' => $languageData
        ]);

        return $formData;
    }
}
