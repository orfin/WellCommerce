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

namespace WellCommerce\Bundle\LayoutBundle\Manager\Box;

use WellCommerce\Bundle\CoreBundle\Event\FormEvent;

/**
 * Interface LayoutBoxConfiguratorInterface
 *
 * @package WellCommerce\Bundle\LayoutBundle\Manager\Box
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface LayoutBoxConfiguratorInterface
{
    /**
     * Checks whether given layout page can handle such a layout box
     *
     * @param string $layoutPage
     *
     * @return bool
     */
    public function isAvailableForLayoutPage($layoutPage);

    /**
     * Prepares layout box configuration fields
     *
     * @param FormEvent $event
     *
     * @return void|bool
     */
    public function addConfigurationFields(FormEvent $event);

    /**
     * Adds box configuration options to settings fieldset
     *
     * @return void|bool
     */
    public function addBoxConfiguration();
}