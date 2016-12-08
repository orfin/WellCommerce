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

namespace WellCommerce\Bundle\AdminBundle\Entity;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;

/**
 * Interface UserGroupInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface UserGroupInterface extends EntityInterface, BlameableInterface
{
    public function getName() : string;
    
    public function setName(string $name);
    
    public function getUsers() : Collection;
    
    public function setUsers(Collection $users);
    
    public function getPermissions() : Collection;
    
    public function setPermissions(Collection $permissions);
}
