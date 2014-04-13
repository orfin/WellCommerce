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

use WellCommerce\Core\Component\Form\AbstractFormBuilder;
use WellCommerce\Core\Component\Form\Conditions\Equals;
use WellCommerce\Core\Component\Form\Dependency;
use WellCommerce\Core\Component\Form\FormInterface;
use WellCommerce\Core\Component\Form\Option;
use WellCommerce\Plugin\Layout\Event\LayoutBoxFormEvent;

/**
 * Class LayoutBoxForm
 *
 * @package WellCommerce\Plugin\LayoutBox\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxForm extends AbstractFormBuilder implements FormInterface
{
    private $types = [];
    private $configurators = [];

    /**
     * Initializes Form
     *
     * @param array $layoutBoxData
     *
     * @return mixed|\WellCommerce\Core\Component\Form\Elements\Form
     */
    public function init($layoutBoxData = [])
    {
        $this->configurators = $this->getLayoutManager()->getLayoutBoxConfigurators();
        $this->types         = $this->getLayoutBoxTypes();

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

        $alias = $requiredData->addChild($this->addSelect([
            'name'    => 'alias',
            'label'   => $this->trans('Box type'),
            'options' => $this->makeOptions($this->types, false),
        ]));

        foreach ($this->configurators as $id => $configurator) {
            $settings = $form->addChild($this->addFieldset([
                'name'         => $configurator->getFieldSetName(),
                'label'        => $this->trans('Settings'),
                'dependencies' => [
                    $this->addDependency(Dependency::SHOW, $alias, new Equals($id), null)
                ]
            ]));

            $settings->addChild($this->addSelect([
                'name'    => 'header',
                'label'   => $this->trans('Show box header'),
                'options' => [
                    new Option('0', $this->trans('Yes')),
                    new Option('1', $this->trans('No'))
                ]
            ]));

            $settings->AddChild($this->addSelect([
                'name'    => 'enable',
                'label'   => $this->trans('Box visible'),
                'options' => [
                    new Option('0', 'for all clients'),
                    new Option('1', 'only for logged-in ones'),
                    new Option('2', 'only for logged-out ones'),
                    new Option('3', 'for no one')
                ]
            ]));

            $configurator->addConfigurationFields($settings);
        }

        $event = new LayoutBoxFormEvent($form, $layoutBoxData);

        $this->getDispatcher()->dispatch(LayoutBoxFormEvent::FORM_INIT_EVENT, $event);

        $populateData = $event->getPopulateData();

        if (!empty($populateData)) {
            $form->populate($populateData);
        }


        $form->addFilters([
            $this->addFilterNoCode(),
            $this->addFilterTrim(),
            $this->addFilterSecure()
        ]);

        return $form;
    }

    /**
     * Prepares select containing all layout box types
     *
     * @return array
     */
    private function getLayoutBoxTypes()
    {
        $types = [];
        foreach ($this->configurators as $id => $configurator) {
            $types[$id] = sprintf('%s - %s', $id, $this->trans($configurator->getName()));
        }

        return $types;
    }

}
