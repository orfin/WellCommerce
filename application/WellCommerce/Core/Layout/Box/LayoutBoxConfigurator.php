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

use WellCommerce\Core\Component\Form\AbstractFormBuilder;

/**
 * Class LayoutBoxConfigurator
 *
 * @package WellCommerce\Core\Layout\Box
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class LayoutBoxConfigurator extends AbstractFormBuilder
{
    protected $defaults;

    public function setDefaults(array $defaults)
    {
        if (!preg_match('/Controller\\\Admin\\\(.+)Controller$/', get_class($this), $matches)) {
    }

    /**
     * Replaces dots with dashes in alias and returns FieldSet name
     *
     * @return string
     */
    public function getFieldSetName()
    {
        return strtr($this->getAlias(), '.', '_');
    }

    public function saveSettings($Data)
    {

    }

    public function getHelp()
    {

    }
}