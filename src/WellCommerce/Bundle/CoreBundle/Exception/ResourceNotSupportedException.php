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

namespace WellCommerce\Bundle\CoreBundle\Exception;

/**
 * Class ResourceNotSupportedException
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ResourceNotSupportedException extends \InvalidArgumentException
{
    /**
     * Constructor
     *
     * @param string $className
     * @param string $resourceClassName
     */
    public function __construct($className, $resourceClassName)
    {
        $message = sprintf(
            'Provider of type "%s" does not supports resource "%s"',
            $className,
            $resourceClassName
        );

        parent::__construct($message);
    }
}
