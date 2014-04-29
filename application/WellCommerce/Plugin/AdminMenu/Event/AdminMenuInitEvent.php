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
namespace WellCommerce\Plugin\AdminMenu\Event;

use WellCommerce\Core\Event\AdminMenuEvent;

/**
 * Class AdminMenuInitEvent
 *
 * @package WellCommerce\Plugin\AdminMenu\Event
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class AdminMenuInitEvent extends AdminMenuEvent
{
    const ADMIN_MENU_INIT_EVENT = 'admin_menu.init';
}