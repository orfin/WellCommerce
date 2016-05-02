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
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Symfony\Component\Security\Core\User\UserInterface as BaseUserInterface;
use WellCommerce\Bundle\DoctrineBundle\Behaviours\Enableable\EnableableTrait;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;

/**
 * Class User
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class User extends AbstractEntity implements UserInterface
{
    use Timestampable;
    use Blameable;
    use EnableableTrait;
    
    /**
     * @var string
     */
    protected $firstName;
    
    /**
     * @var string
     */
    protected $lastName;
    
    /**
     * @var string
     */
    protected $username;
    
    /**
     * @var string
     */
    protected $apiKey;
    
    /**
     * @var string
     */
    protected $password;
    
    /**
     * @var string
     */
    protected $email;
    
    /**
     * @var string
     */
    protected $salt;
    
    /**
     * @var Collection
     */
    protected $roles;
    
    /**
     * @var Collection
     */
    protected $groups;
    
    /**
     * {@inheritdoc}
     */
    public function getFirstName() : string
    {
        return $this->firstName;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getLastName() : string
    {
        return $this->lastName;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->username;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getEmail() : string
    {
        return $this->email;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        return;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setPassword($password)
    {
        if (strlen($password)) {
            $this->password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return $this->roles->toArray();
    }
    
    /**
     * {@inheritdoc}
     */
    public function addRole(RoleInterface $role)
    {
        $this->roles[] = $role;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setRoles(Collection $roles)
    {
        $this->roles = $roles;
    }
    
    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }
    
    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize([$this->id, $this->username, $this->password]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        list($this->id, $this->username, $this->password) = unserialize($serialized);
    }
    
    /**
     * {@inheritdoc}
     */
    public function isEqualTo(BaseUserInterface $user)
    {
        if ($this->password !== $user->getPassword()) {
            return false;
        }
        
        if ($this->salt !== $user->getSalt()) {
            return false;
        }
        
        if ($this->username !== $user->getUsername()) {
            return false;
        }
        
        return true;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getGroups() : Collection
    {
        return $this->groups;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setGroups(Collection $groups)
    {
        $this->groups = $groups;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getApiKey() : string
    {
        return $this->apiKey;
    }
    
    /**
     * {@inheritdoc}122
     */
    public function setApiKey(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }
    
    public function __toString() : string
    {
        return sprintf('%s %s', $this->getFirstName(), $this->getLastName());
    }
}
