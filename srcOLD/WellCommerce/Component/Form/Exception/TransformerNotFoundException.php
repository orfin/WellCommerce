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
class TransformerNotFoundException extends \RuntimeException
{
    /**
     * Constructor
     *
     * @param string $name
     * @param string $class
     */
    public function __construct($name, $class)
    {
        parent::__construct(sprintf('No transformer found for field "%s" with class "%s"', $name, $class));
    }
}
