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
namespace WellCommerce\Plugin\Unit\Form;

use WellCommerce\Core\Form,
    WellCommerce\Plugin\Unit\Event\UnitFormEvent;

/**
 * Class UnitForm
 *
 * @package WellCommerce\Plugin\Unit\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UnitForm extends Form
{
    /**
     * Initializes UnitForm
     *
     * @param array $unitData
     *
     * @return Form\Elements\Form
     */
    public function init($unitData = [])
    {
        $form = $this->addForm(Array(
            'name'   => 'unit',
            '_action' => '',
            'method' => 'post'
        ));

        $requiredData = $form->addChild($this->addFieldset([
            'name'  => 'required_data',
            'label' => $this->trans('Required data')
        ]));

        $languageData = $requiredData->addChild($this->addFieldsetLanguage([
            'name'      => 'language_data',
            'label'     => $this->trans('Translations'),
            'languages' => $this->getLanguages()
        ]));

        $languageData->addChild($this->addTextField([
            'name'  => 'name',
            'label' => $this->trans('Name'),
            'rules' => [
                $this->addRuleRequired($this->trans('Name is required')),
                $this->addRuleLanguageUnique($this->trans('Name already exists'),
                    [
                        'table'   => 'unit_translation',
                        'column'  => 'name',
                        'exclude' => [
                            'column' => 'unit_id',
                            'values' => $this->getParam('id')
                        ]
                    ]
                )
            ]
        ]));

        $form->addFilter($this->addFilterNoCode());

        $form->addFilter($this->addFilterTrim());

        $form->addFilter($this->addFilterSecure());

        $event = new UnitFormEvent($form, $unitData);

        $this->getDispatcher()->dispatch(UnitFormEvent::FORM_INIT_EVENT, $event);

        $form->populate($event->getPopulateData());

        return $form;
    }
}
