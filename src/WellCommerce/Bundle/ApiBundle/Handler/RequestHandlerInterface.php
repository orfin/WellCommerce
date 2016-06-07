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

namespace WellCommerce\Bundle\ApiBundle\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use WellCommerce\Bundle\DoctrineBundle\Manager\ManagerInterface;

/**
 * Interface RequestHandlerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface RequestHandlerInterface
{
    const RESPONSE_FORMAT = 'json';
    
    public function getResourceType() : string;
    
    public function getManager() : ManagerInterface;
    
    public function getSerializer() : SerializerInterface;
    
    public function handleListRequest(Request $request) : Response;
    
    public function handleGetRequest(Request $request, int $identifier) : Response;
    
    public function handleCreateRequest(Request $request) : Response;
    
    public function handleUpdateRequest(Request $request, int $identifier) : Response;
    
    public function handleDeleteRequest(Request $request, int $identifier) : Response;
}
