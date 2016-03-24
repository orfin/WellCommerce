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

namespace WellCommerce\Component\Form\Exception;

/**
 * Class MissingOptionException
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class MissingOptionException extends \InvalidArgumentException
{
    /**
     * Constructor
     *
     * @param string $option
     * @param int    $class
     */
    public function __construct($option, $class)
    {
        parent::__construct(sprintf('Option "%s" for element "%s" does not exists', $option, $class));
    }
}
