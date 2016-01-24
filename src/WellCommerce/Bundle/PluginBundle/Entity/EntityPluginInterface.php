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

namespace WellCommerce\Bundle\PluginBundle;

/**
 * Interface EntityPluginInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface EntityPluginInterface
{
    public function getExtendedEntityFields();

    public function getExtendedEntityAssociations();

    public function supports();
}
