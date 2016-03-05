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

namespace WellCommerce\Bundle\ReportBundle\Data;

/**
 * Class ReportRow
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ReportRow
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var array|string
     */
    protected $value;

    /**
     * Constructor
     *
     * @param string       $identifier
     * @param array|string $value
     */
    public function __construct($identifier, $value)
    {
        $this->identifier = $identifier;
        $this->value      = $value;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return array|string
     */
    public function getValue()
    {
        return $this->value;
    }
}
