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

namespace WellCommerce\Bundle\LayoutBundle\Manager\Box;

/**
 * Class LayoutBox
 *
 * @package WellCommerce\Bundle\LayoutBundle\Manager\Box
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBox
{
    /**
     * @var int Box id
     */
    public $id;

    /**
     * @var array Box settings
     */
    public $settings;

    /**
     * @var string Box type
     */
    public $type;

    /**
     * @var string Controller service name
     */
    public $controller;

    /**
     * @var int Column span for box
     */
    public $span;

    /**
     * Constructor
     *
     * @param $box
     * @param $controller
     */
    public function __construct($box, $controller)
    {
        $this->id         = $box->box->id;
        $this->settings   = $box->box->settings;
        $this->type       = $box->box->type;
        $this->span       = $box->span;
        $this->controller = $controller;
    }
}