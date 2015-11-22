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

namespace WellCommerce\AppBundle\Entity;

/**
 * Class UserGroupPermission
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface UserGroupPermissionInterface
{
    /**
     * @return bool
     */
    public function getEnabled();

    /**
     * @param bool $enabled
     */
    public function setEnabled($enabled);
}
