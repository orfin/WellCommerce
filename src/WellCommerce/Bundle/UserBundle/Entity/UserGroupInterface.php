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

namespace WellCommerce\Bundle\AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\AppBundle\Entity\BlameableInterface;

/**
 * Interface UserGroupInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface UserGroupInterface extends BlameableInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return Collection
     */
    public function getUsers();

    /**
     * @return Collection
     */
    public function getPermissions();

    /**
     * @param Collection $permissions
     */
    public function setPermissions(Collection $permissions);
}
