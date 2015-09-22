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

namespace WellCommerce\Bundle\AdminBundle\Manager;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Manager\ManagerInterface;
use WellCommerce\Bundle\DataGridBundle\DataGridInterface;
use WellCommerce\Bundle\FormBundle\FormBuilderInterface;

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
     * Returns form object
     *
     * @return FormBuilderInterface
     */
    public function getFormBuilder();

    /**
     * Returns form instance from builder
     *
     * @param object $resource
     * @param array  $config
     *
     * @return \WellCommerce\Bundle\FormBundle\Elements\FormInterface
     */
    public function getForm($resource, array $config = []);
}
