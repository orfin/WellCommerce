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

    /**
     * @var
     */
    private $width;

    /**
     * @var
     */
    private $template;

    /**
     * @var array
     */
    private $boxes = [];

    /**
     * Constructor
     *
     * @param       $width
     * @param       $template
     * @param array $boxes
     */
    public function __construct($width, $template, $boxes = array())
    {
        $this->width    = $width;
        $this->template = $template;
        $this->boxes    = $boxes;
    }

    /**
     * Returns column width
     *
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Returns template which will be used as column placeholder
     *
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Returns boxes added to column
     *
     * @return array
     */
    public function getBoxes()
    {
        return $this->boxes;
    }
} 