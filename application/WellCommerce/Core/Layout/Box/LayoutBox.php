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

/**
 * Class LayoutBox
 *
 * @package WellCommerce\Core\Layout
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBox
{
    private $id;
    private $class;
    private $defaults;

    public function __construct($id, $class, $defaults = array())
    {
        $this->id       = $id;
        $this->class    = $class;
        $this->defaults = $defaults;
    }

    /**
     * Returns box identifier
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
} 