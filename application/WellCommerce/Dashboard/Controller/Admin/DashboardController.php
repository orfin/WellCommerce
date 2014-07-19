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
namespace WellCommerce\Dashboard\Controller\Admin;

use WellCommerce\Core\Controller\AbstractAdminController;

/**
 * Class DashboardController
 *
 * @package WellCommerce\Dashboard\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DashboardController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    protected function getDataGrid()
    {
        return $this->get('dashboard.datagrid');
    }

    /**
     * {@inheritdoc}
     */
    protected function getRepository()
    {
        return $this->get('dashboard.repository');
    }

    /**
     * {@inheritdoc}
     */
    protected function getForm()
    {
        return $this->get('dashboard.form');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultRoute()
    {
        return 'admin.dashboard.index';
    }
}
