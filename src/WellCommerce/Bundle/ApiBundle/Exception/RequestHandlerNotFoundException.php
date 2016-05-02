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
 * Class RequestHandlerNotFoundException
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RequestHandlerNotFoundException extends \InvalidArgumentException
{
    protected $message = 'Request handler for resource "%s" was not found in request handlers collection. Available request handlers are: %s';
    
    public function __construct($alias, $keys)
    {
        parent::__construct(sprintf($this->message, $alias, implode(', ', $keys)));
    }
}
