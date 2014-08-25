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

namespace WellCommerce\Bundle\LayoutBundle\Manager\Column;

use WellCommerce\Bundle\CoreBundle\Layout\Box\LayoutBoxCollection;

/**
 * Class LayoutColumn
 *
 * @package WellCommerce\Bundle\LayoutBundle\Manager\Column
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutColumn
{
    /**
     * @var int Column width
     */
    public $width;

    /**
     * @var array An array containing all boxes bound to column
     */
    public $boxes = [];

    /**
     * Constructor
     *
     * @param       $width
     * @param       $template
     * @param array $boxes
     */
    public function __construct($width, LayoutBoxCollection $boxes)
    {
        $this->width = $width;
        $this->boxes = $boxes->all();
    }
}