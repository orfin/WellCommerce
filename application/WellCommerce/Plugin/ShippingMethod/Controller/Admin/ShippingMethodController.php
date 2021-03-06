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
namespace WellCommerce\Plugin\ShippingMethod\Controller\Admin;

use WellCommerce\Core\Controller\AdminController;

/**
 * Class ShippingMethodController
 *
 * @package WellCommerce\Plugin\ShippingMethod\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingMethodController extends AdminController
{
    /**
     * {@inheritdoc}
     */
    protected function getDataGrid()
    {
        return $this->get('shipping_method.datagrid');
    }

    /**
     * {@inheritdoc}
     */
    protected function getRepository()
    {
        return $this->get('shipping_method.repository');
    }

    /**
     * {@inheritdoc}
     */
    protected function getForm()
    {
        return $this->get('shipping_method.form');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultRoute()
    {
        return 'admin.shipping_method.index';
    }
}
