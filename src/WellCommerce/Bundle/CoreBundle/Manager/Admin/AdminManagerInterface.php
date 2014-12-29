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

namespace WellCommerce\Bundle\CoreBundle\Manager\Admin;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Manager\ManagerInterface;

/**
 * Interface AdminManagerInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\Manager\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface AdminManagerInterface extends ManagerInterface
{
    /**
     * Persists new resource
     *
     * @param         $resource
     * @param Request $request
     *
     * @return mixed
     */
    public function createResource($resource, Request $request);

    /**
     * Updates existing resource
     *
     * @param         $resource
     * @param Request $request
     *
     * @return mixed
     */
    public function updateResource($resource, Request $request);

    /**
     * Removes a resource
     *
     * @param $resource
     *
     * @return mixed
     */
    public function removeResource($resource);

    /**
     * Returns datagrid object
     *
     * @return \WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface
     */
    public function getDataGrid();

    /**
     * Returns form object
     *
     * @return \WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface
     */
    public function getFormBuilder();

    /**
     * Returns repository object
     *
     * @return \WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface
     */
    public function getRepository();
}