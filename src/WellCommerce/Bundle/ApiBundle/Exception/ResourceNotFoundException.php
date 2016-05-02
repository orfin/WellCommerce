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
 * Class ResourceNotFoundException
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ResourceNotFoundException extends \InvalidArgumentException
{
    protected $message = 'Resource "%s" for given ID "%s" was not found.';
    
    public function __construct($alias, $identifier)
    {
        parent::__construct(sprintf($this->message, $alias, $identifier));
    }
}
