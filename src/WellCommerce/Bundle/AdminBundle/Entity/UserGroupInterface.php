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
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;

/**
 * Interface UserGroupInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface UserGroupInterface extends EntityInterface, BlameableInterface
{
    /**
     * @return string
     */
    public function getName() : string;
    
    /**
     * @param string $name
     */
    public function setName(string $name);
    
    /**
     * @return Collection
     */
    public function getUsers() : Collection;
    
    /**
     * @return Collection
     */
    public function getPermissions() : Collection;
    
    /**
     * @param Collection $permissions
     */
    public function setPermissions(Collection $permissions);
}
