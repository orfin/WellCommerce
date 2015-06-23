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

namespace WellCommerce\Bundle\LayoutBundle\Collection;

use WellCommerce\Bundle\CoreBundle\Collection\AbstractCollection;

/**
 * Class LayoutBoxSettingsCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxSettingsCollection extends AbstractCollection
{
    /**
     * Adds parameter to stack
     *
     * @param string $param
     * @param mixed  $value
     */
    public function add($name, $value)
    {
        $this->items[$name] = $value;
    }

    /**
     * Returns box param or default value
     *
     * @param      $name
     * @param null $default
     *
     * @return null
     */
    public function getParam($name, $default = null)
    {
        return array_key_exists($name, $this->items) ? $this->items[$name] : $default;
    }
}
