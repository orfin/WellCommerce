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

namespace WellCommerce\Core\Layout;

use WellCommerce\Core\Form\Elements\Fieldset;

/**
 * Interface LayoutPageConfiguratorInterface
 *
 * @package WellCommerce\Core\Layout
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface LayoutPageConfiguratorInterface
{

    /**
     * Returns layout box human-friendly name
     *
     * @return mixed
     */
    public function getName();

    /**
     * Returns layout box alias
     *
     * @return mixed
     */
    public function getAlias();
}