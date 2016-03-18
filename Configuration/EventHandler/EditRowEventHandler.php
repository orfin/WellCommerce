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

namespace WellCommerce\Component\DataGrid\Configuration\EventHandler;

/**
 * Class EditRowEventHandler
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class EditRowEventHandler extends ClickRowEventHandler
{
    /**
     * {@inheritdoc}
     */
    public function getFunctionName() : string
    {
        return 'edit_row';
    }
}
