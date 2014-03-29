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

namespace WellCommerce\Core\Layout\Box;

use WellCommerce\Core\Form;

/**
 * Class LayoutBoxConfigurator
 *
 * @package WellCommerce\Core\Layout\Box
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class LayoutBoxConfigurator extends Form
{
    /**
     * Replaces dots with dashes in alias and returns FieldSet name
     *
     * @return string
     */
    public function getFieldSetName()
    {
        return strtr($this->getAlias(), '.', '_');
    }

    /**
     * Prepares and adds a FieldSet as additional tab
     *
     * @param Form\Elements\Form $form
     *
     * @return mixed
     */
    public function addSettingsFieldSet(Form\Elements\Form $form)
    {
        return $form->addChild($this->addFieldset([
            'name'         => $this->getFieldSetName(),
            'label'        => $this->trans('Settings'),
            'dependencies' => [
                $this->addDependency(Form\Dependency::SHOW, $form->getChild('alias'), new Form\Conditions\Equals($this->getAlias()), null)
            ]
        ]));
    }

    public function saveSettings($Data)
    {

    }
}