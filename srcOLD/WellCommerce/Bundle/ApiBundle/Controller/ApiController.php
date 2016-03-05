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
use WellCommerce\Bundle\ApiBundle\Request\RequestHandlerCollection;
use WellCommerce\Bundle\CoreBundle\Controller\AbstractController;

/**
 * Class ApiController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ApiController extends AbstractController
{
    /**
     * @var RequestHandlerCollection
     */
    protected $requestHandlerCollection;

    /**
     * ApiController constructor.
     *
     * @param RequestHandlerCollection $requestHandlerCollection
     */
    public function __construct(RequestHandlerCollection $requestHandlerCollection)
    {
        $this->requestHandlerCollection = $requestHandlerCollection;
    }

    public function indexAction(Request $request)
    {
        return new Response('documentation');
    }

    /**
     * Handles create action
     *
     * @param Request $request
     * @param string  $resourceType
     *
     * @return JsonResponse
     */
    public function createResourceAction(Request $request, $resourceType)
    {
        try {
            $response = $this->getRequestHandler($resourceType)->handleCreateRequest($request);
        } catch (\Exception $e) {
            $response = $this->jsonErrorResponse($e);
        }

        return $response;
    }

    /**
     * Handles the "update" action
     *
     * @param Request $request
     * @param string  $resourceType
     * @param int     $identifier
     *
     * @return JsonResponse
     */
    public function updateResourceAction(Request $request, $resourceType, $identifier)
    {
        try {
            $response = $this->getRequestHandler($resourceType)->handleUpdateRequest($request, $identifier);
        } catch (\Exception $e) {
            $response = $this->jsonErrorResponse($e);
        }

        return $response;
    }

    /**
     * Handles the "update" action
     *
     * @param Request $request
     * @param string  $resourceType
     * @param int     $identifier
     *
     * @return JsonResponse
     */
    public function deleteResourceAction(Request $request, $resourceType, $identifier)
    {
        try {
            $response = $this->getRequestHandler($resourceType)->handleDeleteRequest($request, $identifier);
        } catch (\Exception $e) {
            $response = $this->jsonErrorResponse($e);
        }

        return $response;
    }

    /**
     * Handles the "get" action
     *
     * @param Request $request
     * @param string  $resourceType
     * @param int     $identifier
     *
     * @return JsonResponse
     */
    public function getResourceAction(Request $request, $resourceType, $identifier)
    {
        try {
            $response = $this->getRequestHandler($resourceType)->handleGetRequest($request, $identifier);
        } catch (\Exception $e) {
            $response = $this->jsonErrorResponse($e);
        }

        return $response;
    }

    /**
     * Handles the "list" action
     *
     * @param Request $request
     * @param string  $resourceType
     *
     * @return JsonResponse
     */
    public function listResourceAction(Request $request, $resourceType)
    {
        try {
            $response = $this->getRequestHandler($resourceType)->handleListRequest($request);
        } catch (\Exception $e) {
            $response = $this->jsonErrorResponse($e);
        }

        return $response;
    }

    /**
     * Handles the exception
     *
     * @param \Exception $e
     *
     * @return JsonResponse
     */
    protected function jsonErrorResponse(\Exception $e)
    {
        return new JsonResponse(
            ['message' => $e->getMessage()],
            404
        );
    }

    /**
     * Returns the request handler for given resource type
     *
     * @param string $resourceType
     *
     * @return \WellCommerce\Bundle\ApiBundle\Request\RequestHandlerInterface
     */
    protected function getRequestHandler($resourceType)
    {
        return $this->requestHandlerCollection->get($resourceType);
    }
}
