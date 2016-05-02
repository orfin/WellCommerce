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

namespace WellCommerce\Bundle\ApiBundle\Exception;

/**
 * Class NonUniqueRequestHandlerException
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class NonUniqueRequestHandlerException extends \InvalidArgumentException
{
    protected $message = 'Request handler for resource "%s" already exists in collection.';
    
    public function __construct($alias)
    {
        parent::__construct(sprintf($this->message, $alias));
    }
}
