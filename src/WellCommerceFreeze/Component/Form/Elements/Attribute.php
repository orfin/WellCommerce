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

namespace WellCommerce\Component\Form\Elements;

/**
 * Class Attribute
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class Attribute
{
    const TYPE_STRING   = 'string';
    const TYPE_BOOLEAN  = 'bool';
    const TYPE_INTEGER  = 'int';
    const TYPE_ARRAY    = 'array';
    const TYPE_FUNCTION = 'function';

    /**
     * @var string
     */
    protected $name;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var string
     */
    protected $type;

    /**
     * Constructor
     *
     * @param string $name
     * @param mixed  $value
     * @param string $type
     */
    public function __construct($name, $value, $type = self::TYPE_STRING)
    {
        $this->name  = $name;
        $this->value = $value;
        $this->type  = $type;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
