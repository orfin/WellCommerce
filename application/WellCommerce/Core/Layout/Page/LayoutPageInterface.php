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

namespace WellCommerce\Core\Layout\Page;

/**
 * Interface LayoutPageInterface
 *
 * @package WellCommerce\Core\Layout
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface LayoutPageInterface
{
    /**
     * Returns layout XML filename
     *
     * @return mixed
     */
    public function getLayoutXml();

    /**
     * Loads columns configuration for layout page
     *
     * @return mixed
     */
    public function load();

    /**
     * Render layout page
     *
     * @return mixed
     */
    public function render();
}