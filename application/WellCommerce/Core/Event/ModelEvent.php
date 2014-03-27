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
namespace WellCommerce\Core\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class ModelEvent
 *
 * @package WellCommerce\Core\Event
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ModelEvent extends Event
{

    /**
     * @var array
     */
    protected $data = Array();

    /**
     * @var null
     */
    protected $id = null;

    public function __construct($data, $id)
    {
        $this->data = $data;
        $this->id   = $id;
    }

    public function getSubmittedData()
    {
        return $this->data;
    }

    public function getId()
    {
        return $this->id;
    }
}