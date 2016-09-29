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
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface as BaseUserInterface;
use WellCommerce\Bundle\CoreBundle\Behaviours\Enableable\EnableableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;

/**
 * Interface UserInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface UserInterface extends \Serializable, EquatableInterface, BaseUserInterface, TimestampableInterface, EntityInterface, EnableableInterface
{
    /**
     * @return string
     */
    public function getFirstName() : string;
    
    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName);
    
    /**
     * @return string
     */
    public function getLastName() : string;
    
    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName);
    
    /**
     * @return string
     */
    public function getUsername();
    
    /**
     * @param string $username
     */
    public function setUsername($username);
    
    /**
     * @return string
     */
    public function getEmail() : string;
    
    /**
     * @param string $email
     */
    public function setEmail(string $email);
    
    /**
     * @param string $salt
     */
    public function setSalt($salt);
    
    /**
     * @inheritDoc
     */
    public function getSalt();
    
    /**
     * @return string
     */
    public function getPassword();
    
    /**
     * @param string $password
     */
    public function setPassword($password);
    
    /**
     * @return array
     */
    public function getRoles();
    
    /**
     * @param RoleInterface $role
     */
    public function addRole(RoleInterface $role);
    
    /**
     * @param Collection $roles
     */
    public function setRoles(Collection $roles);
    
    
    /**
     * @return Collection
     */
    public function getGroups() : Collection;
    
    /**
     * @param Collection $groups
     */
    public function setGroups(Collection $groups);
    
    /**
     * @return string
     */
    public function getApiKey() : string;
    
    /**
     * @param string $apiKey
     */
    public function setApiKey(string $apiKey);
}
