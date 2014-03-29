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

namespace WellCommerce\Core\Layout\Column;

/**
 * Class LayoutColumn
 *
 * @package WellCommerce\Core\Layout\Column
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutColumn
{

    protected $width;
    protected $boxes;

    public function __construct($width, $boxes = array())
    {
        $this->width = $width;
        $this->boxes = $boxes;
    }
} 