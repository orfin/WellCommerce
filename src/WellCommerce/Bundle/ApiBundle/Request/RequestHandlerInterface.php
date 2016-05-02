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

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface RequestHandlerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface RequestHandlerInterface
{
    const RESPONSE_FORMAT = 'json';
    
    /**
     * @return string
     */
    public function getResourceType();
    
    /**
     * @return \WellCommerce\Component\DataSet\DataSetInterface
     */
    public function getDataset();
    
    /**
     * @return \WellCommerce\Bundle\CoreBundle\Manager\ManagerInterface
     */
    public function getManager();
    
    /**
     * @return \Symfony\Component\Serializer\SerializerInterface
     */
    public function getSerializer();
    
    /**
     * Handles the "list" request for given resource
     *
     * @return array
     */
    public function handleListRequest(Request $request);
    
    /**
     * Handles the "get" request for given resource
     *
     * @param Request $request
     * @param int     $identifier
     *
     * @return array
     */
    public function handleGetRequest(Request $request, $identifier);
    
    /**
     * Handles the "create" request for given resource
     *
     * @param Request $request
     *
     * @return array
     */
    public function handleCreateRequest(Request $request);
    
    /**
     * Handles the "update" request for given resource
     *
     * @param Request $request
     * @param int     $identifier
     *
     * @return array
     */
    public function handleUpdateRequest(Request $request, $identifier);
    
    /**
     * Handles the "delete" request for given resource
     *
     * @param Request $request
     * @param int     $identifier
     *
     * @return array
     */
    public function handleDeleteRequest(Request $request, $identifier);
}
