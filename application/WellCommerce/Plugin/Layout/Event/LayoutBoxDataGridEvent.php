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
namespace WellCommerce\Plugin\Layout\Event;

use WellCommerce\Core\Event\DataGridEvent;

/**
 * Class LayoutBoxDataGridEvent
 *
 * @package WellCommerce\Plugin\Layout\Event
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class LayoutBoxDataGridEvent extends DataGridEvent
{

    const DATAGRID_INIT_EVENT = 'layout_box.datagrid.init';
}