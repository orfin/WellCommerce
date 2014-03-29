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
namespace WellCommerce\Plugin\Layout\Form;

use Symfony\Component\EventDispatcher\GenericEvent;
use WellCommerce\Core\Form;
use WellCommerce\Plugin\Layout\Event\LayoutBoxFormEvent;

/**
 * Class LayoutBoxForm
 *
 * @package WellCommerce\Plugin\LayoutBox\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxForm extends Form
{
    private $types = [];

    /**
     * Initializes layout_box Form
     *
     * @param array $layoutBoxData
     *
     * @return Form\Elements\Form
     */
    public function init($layoutBoxData = [])
    {
        $this->getLayoutBoxTypes();

        $form = $this->addForm([
            'name' => 'layout_box',
        ]);

        $requiredData = $form->addChild($this->addFieldset([
            'name'  => 'required_data',
            'label' => $this->trans('Required data')
        ]));

        $requiredData->addChild($this->addTextField([
            'name'  => 'identifier',
            'label' => $this->trans('Identifier'),
            'rules' => [
                $this->addRuleRequired($this->trans('Identifier is required')),
                $this->addRuleUnique($this->trans('Identifier already exists'),
                    [
                        'table'   => 'layout_box',
                        'column'  => 'identifier',
                        'exclude' => [
                            'column' => 'id',
                            'values' => $this->getParam('id')
                        ]
                    ]
                ),
            ]
        ]));

        $requiredData->addChild($this->addSelect([
            'name'    => 'alias',
            'label'   => $this->trans('Box type'),
            'options' => $this->makeOptions($this->types, true)
        ]));

        $event = new LayoutBoxFormEvent($form, $layoutBoxData);

        $this->getDispatcher()->dispatch(LayoutBoxFormEvent::FORM_INIT_EVENT, $event);

        $form->populate($event->getPopulateData());

        $form->addFilters([
            $this->addFilterNoCode(),
            $this->addFilterTrim(),
            $this->addFilterSecure()
        ]);

        return $form;
    }

    private function getLayoutBoxTypes()
    {
        $event = new GenericEvent();

        $this->getDispatcher()->dispatch(LayoutBoxFormEvent::FORM_GET_BOX_TYPES, $event);

        foreach ($event->getArguments() as $id => $name) {
            $this->types[$id] = sprintf('%s - %s', $id, $this->trans($name));
        }
    }

}
