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
namespace WellCommerce\Plugin\Deliverer\Controller\Admin;

use WellCommerce\Core\Controller\AbstractAdminController;

/**
 * Class DelivererController
 *
 * @package WellCommerce\Plugin\Deliverer\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DelivererController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    protected function getDataGrid()
    {
        return $this->get('deliverer.datagrid');
    }

    /**
     * {@inheritdoc}
     */
    protected function getRepository()
    {
        return $this->get('deliverer.repository');
    }

    /**
     * {@inheritdoc}
     */
    protected function getForm()
    {
        return $this->get('deliverer.form');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultRoute()
    {
        return 'admin.deliverer.index';
    }
}
