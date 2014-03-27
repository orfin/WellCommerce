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
namespace WellCommerce\Plugin\ClientGroup\Event;

use WellCommerce\Core\Event\DataGridEvent;

/**
 * Class ClientGroupDataGridEvent
 *
 * @package WellCommerce\Plugin\ClientGroup\Event
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ClientGroupDataGridEvent extends DataGridEvent
{

    const DATAGRID_INIT_EVENT = 'client_group.datagrid.init';
}