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

namespace WellCommerce\Bundle\AdminBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\AdminBundle\Entity\User;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;

/**
 * Class UserFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\Bundle\AdminBundle\Entity\UserInterface
     */
    public function create()
    {
        $user = new User();
        $user->setEnabled(true);
        $user->setRoles(new ArrayCollection());
        $user->setGroups(new ArrayCollection());
        $user->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));
        $user->setCreatedAt(new \DateTime());

        return $user;
    }
}
