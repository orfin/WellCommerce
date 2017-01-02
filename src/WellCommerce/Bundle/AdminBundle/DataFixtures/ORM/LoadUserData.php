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

namespace WellCommerce\Bundle\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\AdminBundle\Entity\Role;
use WellCommerce\Bundle\AdminBundle\Entity\User;
use WellCommerce\Bundle\AdminBundle\Entity\UserGroup;
use WellCommerce\Bundle\AdminBundle\Entity\UserGroupInterface;
use WellCommerce\Bundle\AdminBundle\Entity\UserGroupPermission;
use WellCommerce\Bundle\CoreBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;

/**
 * Class LoadUserData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadUserData extends AbstractDataFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        if (!$this->isEnabled()) {
            return;
        }
        
        $role = new Role();
        $role->setName('admin');
        $role->setRole('ROLE_ADMIN');
        $manager->persist($role);
        
        $this->setReference('default_role', $role);
        
        $group = new UserGroup();
        $group->setName('Administration');
        $group->setPermissions($this->getPermissions($group));
        $manager->persist($group);
        
        $this->setReference('default_group', $group);
        
        $user = new User();
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setUsername('admin');
        $user->setEmail('admin@domain.org');
        $user->setEnabled(1);
        $user->setPassword('admin');
        $user->addRole($role);
        $user->getGroups()->add($group);
        $user->setApiKey(Helper::generateRandomPassword(8));
        $manager->persist($user);
        
        $manager->flush();
    }
    
    private function getPermissions(UserGroupInterface $group)
    {
        $collection = new ArrayCollection();
        foreach ($this->container->get('router')->getRouteCollection()->all() as $name => $route) {
            if ($route->hasOption('require_admin_permission')) {
                $permission = new UserGroupPermission();
                $permission->setEnabled(true);
                $permission->setName($route->getOption('require_admin_permission'));
                $permission->setGroup($group);
                $collection->add($permission);
            }
        }
        
        return $collection;
    }
}
