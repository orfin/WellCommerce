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
 * Interface EventHandlerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface EventHandlerInterface
{
    /**
     * Returns function name
     *
     * @return string
     */
    public function getFunctionName() : string;

    /**
     * Returns event options
     *
     * @return array
     */
    public function getOptions() : array;

    /**
     * Returns boolean indicating if event is custom
     *
     * @return bool
     */
    public function isCustomEvent() : bool;
}
