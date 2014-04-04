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

use WellCommerce\Core\Component\Form\AbstractFormBuilder;
use WellCommerce\Core\Component\Form\FormBuilderInterface;
use WellCommerce\Core\Form;
use WellCommerce\Plugin\Availability\Event\AvailabilityFormEvent;

/**
 * Class AvailabilityForm
 *
 * @package WellCommerce\Plugin\Availability\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityForm extends AbstractFormBuilder implements FormBuilderInterface
{
    /**
     * Initializes availability Form
     *
     * @param array $availabilityData
     *
     * @return Form\Elements\Form
     */
    public function init($availabilityData = [])
    {
        $form = $this->addForm([
            'name'   => 'availability',
        ]);

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

        $languageData->addChild($this->addTextArea([
            'name'  => 'description',
            'label' => $this->trans('Description')
        ]));

        $form->addFilters([
            $this->addFilterNoCode(),
            $this->addFilterTrim(),
            $this->addFilterSecure()
        ]);

        $event = new AvailabilityFormEvent($form, $availabilityData);

        $this->getDispatcher()->dispatch(AvailabilityFormEvent::FORM_INIT_EVENT, $event);

        $form->populate($event->getPopulateData());

        return $form;
    }
}
