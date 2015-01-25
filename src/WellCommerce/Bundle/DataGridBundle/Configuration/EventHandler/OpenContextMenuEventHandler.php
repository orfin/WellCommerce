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

namespace WellCommerce\Bundle\DataGridBundle\Configuration\EventHandler;

/**
 * Class OpenContextMenu
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OpenContextMenuEventHandler extends AbstractEventHandler implements EventHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getFunctionName()
    {
        return 'open_context_menu';
    }
}
