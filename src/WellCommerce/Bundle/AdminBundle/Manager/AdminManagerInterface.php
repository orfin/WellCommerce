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
use WellCommerce\Bundle\FormBundle\Builder\FormBuilderInterface;

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
     * @return mixed
     */
    public function findResource(Request $request);

    /**
     * Returns datagrid object
     *
     * @return DataGridInterface
     */
    public function getDataGrid();

    /**
     * Sets datagrid object
     *
     * @param DataGridInterface $datagrid
     */
    public function setDataGrid(DataGridInterface $datagrid);

    /**
     * Returns form object
     *
     * @return FormBuilderInterface
     */
    public function getFormBuilder();

    /**
     * Sets form builder object
     *
     * @param FormBuilderInterface $formBuilder
     */
    public function setFormBuilder(FormBuilderInterface $formBuilder);

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
