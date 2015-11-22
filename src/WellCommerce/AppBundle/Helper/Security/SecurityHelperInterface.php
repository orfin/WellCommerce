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

namespace WellCommerce\AppBundle\Helper\Security;

use WellCommerce\AdminBundle\Entity\UserInterface;

/**
 * Interface TranslatorHelperInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface SecurityHelperInterface
{
    /**
     * @return object|null
     */
    public function getUser();

    /**
     * Returns a permission for given type and user
     *
     * @param string               $name
     * @param object|UserInterface $user
     *
     * @return array
     */
    public function getPermission($name, UserInterface $user);
}
