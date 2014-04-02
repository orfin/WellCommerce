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
namespace WellCommerce\Plugin\ClientGroup\Controller\Admin;

use WellCommerce\Core\Controller\AbstractAdminController;

/**
 * Class ClientGroupController
 *
 * @package WellCommerce\Plugin\ClientGroup\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientGroupController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    protected function getDataGrid()
    {
        return $this->get('client_group.datagrid');
    }

    /**
     * {@inheritdoc}
     */
    protected function getRepository()
    {
        return $this->get('client_group.repository');
    }

    /**
     * {@inheritdoc}
     */
    protected function getForm()
    {
        return $this->get('client_group.form');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultRoute()
    {
        return 'admin.client_group.index';
    }
}
