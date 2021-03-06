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
namespace WellCommerce\Plugin\ShippingMethod\Event;

use WellCommerce\Core\Event\DataGridEvent;

/**
 * Class ShippingMethodDataGridEvent
 *
 * @package WellCommerce\Plugin\ShippingMethod\Event
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ShippingMethodDataGridEvent extends DataGridEvent
{

    const DATAGRID_INIT_EVENT = 'shipping_method.datagrid.init';
}