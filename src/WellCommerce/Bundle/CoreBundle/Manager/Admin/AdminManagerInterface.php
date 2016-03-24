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
use WellCommerce\Bundle\OrderBundle\Context\Admin\OrderContextInterface;
use WellCommerce\Component\DataGrid\DataGridInterface;

/**
 * Interface AdminManagerInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface AdminManagerInterface extends ManagerInterface
{
    /**
     * Returns current resource or throws an exception
     *
     * @param Request $request
     *
     * @return null|object
     */
    public function findResource(Request $request);

    /**
     * Returns datagrid object
     *
     * @return DataGridInterface
     */
    public function getDataGrid();

    /**
     * @return null|\WellCommerce\Bundle\AdminBundle\Entity\UserInterface
     */
    public function getAdmin();

    /**
     * @return OrderContextInterface
     */
    public function getOrderContext() : OrderContextInterface;
}
