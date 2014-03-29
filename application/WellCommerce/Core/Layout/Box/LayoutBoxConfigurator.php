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

    public function saveSettings($Data)
    {

    }
}