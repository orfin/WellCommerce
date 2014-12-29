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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements;

/**
 * Class ElementAttribute
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ElementAttribute
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @param string $name  Element attribute name
     * @param mixed  $value Element value
     */
    public function __construct($name, $value)
    {
        $this->name  = $name;
        $this->value = $value;
    }

    /**
     * Returns attribute name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns attribute value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
} 