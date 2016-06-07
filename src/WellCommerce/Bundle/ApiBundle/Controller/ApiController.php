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

namespace WellCommerce\Bundle\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\ApiBundle\Handler\RequestHandlerInterface;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;

/**
 * Class ApiController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ApiController extends AbstractContainerAware
{
    public function indexAction() : Response
    {
        return new Response('documentation');
    }
    
    public function createResourceAction(Request $request, string $resourceType) : Response
    {
        try {
            $response = $this->getRequestHandler($resourceType)->handleCreateRequest($request);
        } catch (\Exception $e) {
            $response = $this->jsonErrorResponse($e);
        }
        
        return $response;
    }
    
    public function updateResourceAction(Request $request, string $resourceType, int $identifier) : Response
    {
        try {
            $response = $this->getRequestHandler($resourceType)->handleUpdateRequest($request, $identifier);
        } catch (\Exception $e) {
            $response = $this->jsonErrorResponse($e);
        }
        
        return $response;
    }
    
    public function deleteResourceAction(Request $request, string $resourceType, int $identifier) : Response
    {
        try {
            $response = $this->getRequestHandler($resourceType)->handleDeleteRequest($request, $identifier);
        } catch (\Exception $e) {
            $response = $this->jsonErrorResponse($e);
        }
        
        return $response;
    }
    
    public function getResourceAction(Request $request, string $resourceType, int $identifier) : Response
    {
        try {
            $response = $this->getRequestHandler($resourceType)->handleGetRequest($request, $identifier);
        } catch (\Exception $e) {
            $response = $this->jsonErrorResponse($e);
        }
        
        return $response;
    }
    
    public function listResourceAction(Request $request, string $resourceType) : Response
    {
        try {
            $response = $this->getRequestHandler($resourceType)->handleListRequest($request);
        } catch (\Exception $e) {
            $response = $this->jsonErrorResponse($e);
        }
        
        return $response;
    }
    
    private function jsonErrorResponse(\Exception $e) : JsonResponse
    {
        return new JsonResponse(
            ['message' => $e->getMessage()],
            404
        );
    }
    
    private function getRequestHandler(string $resourceType) : RequestHandlerInterface
    {
        return $this->get('api.request_handler.collection')->get($resourceType);
    }
}
