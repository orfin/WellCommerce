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

namespace WellCommerce\Bundle\ApiBundle\Request;

use WellCommerce\Bundle\ApiBundle\Exception\NonUniqueRequestHandlerException;
use WellCommerce\Bundle\ApiBundle\Exception\RequestHandlerNotFoundException;
use WellCommerce\Component\Collections\ArrayCollection;

/**
 * Class RequestHandlerCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RequestHandlerCollection extends ArrayCollection
{
    /**
     * Adds given request handler to collection
     *
     * @param RequestHandlerInterface $requestHandler
     */
    public function add(RequestHandlerInterface $requestHandler)
    {
        if ($this->has($requestHandler->getResourceType())) {
            throw new NonUniqueRequestHandlerException($requestHandler->getResourceType());
        }
        
        $this->items[$requestHandler->getResourceType()] = $requestHandler;
    }
    
    /**
     * Returns the request handler for given resource type
     *
     * @param $resourceType
     *
     * @return RequestHandlerInterface
     */
    public function get($resourceType)
    {
        if (false === $this->has($resourceType)) {
            throw new RequestHandlerNotFoundException($resourceType, $this->keys());
        }
        
        return $this->items[$resourceType];
    }
    
    /**
     * @return RequestHandlerInterface[]
     */
    public function all()
    {
        return $this->items;
    }
}
