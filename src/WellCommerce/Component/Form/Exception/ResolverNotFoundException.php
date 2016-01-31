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
 * Class ResolverNotFoundException
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ResolverNotFoundException extends \InvalidArgumentException
{
    /**
     * Constructor
     *
     * @param string $type
     */
    public function __construct($type)
    {
        parent::__construct(sprintf('No matching resolver found for "%s"', $type));
    }
}
