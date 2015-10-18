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
namespace WellCommerce\Bundle\ClientBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class Client
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Client implements ClientInterface
{
    use Timestampable, Blameable, ClientAddressAwareTrait;

    const ROLE_CLIENT = 'ROLE_CLIENT';

    /**
     * @var int
     */
    protected $id;

    /**
     * @var float
     */
    protected $discount;

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
    protected $password;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $phone;

    /**
     * @var string
     */
    protected $salt;

    /**
     * @var ClientGroupInterface
     */
    protected $clientGroup;

    /**
     * @var Collection
     */
    protected $orders;

    /**
     * @var Collection
     */
    protected $wishlist;

    /**
     * @var bool
     */
    protected $conditionsAccepted;

    /**
     * @var bool
     */
    protected $newsletterAccepted;

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @inheritDoc
     */
    public function setDiscount($discount)
    {
        $this->discount = (float)$discount;
    }

    /**
     * @inheritDoc
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @inheritDoc
     */
    public function setAddresses(Collection $addresses)
    {
        $this->addresses = $addresses;
    }

    /**
     * @inheritDoc
     */
    public function addAddress(ClientAddressInterface $address)
    {
        $this->addresses[] = $address;
    }

    /**
     * @return ClientGroupInterface
     */
    public function getClientGroup()
    {
        return $this->clientGroup;
    }

    /**
     * @inheritDoc
     */
    public function setClientGroup(ClientGroupInterface $clientGroup)
    {
        $this->clientGroup = $clientGroup;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = (string)$firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = (string)$lastName;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @inheritDoc
     */
    public function setEmail($email)
    {
        $this->email    = (string)$email;
        $this->username = (string)$email;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function setPassword($password)
    {
        if (strlen($password)) {
            $this->password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        }
    }

    /**
     * @return null
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = (string)$salt;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @inheritDoc
     */
    public function setUsername($username)
    {
        $this->username = (string)$username;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return [
            self::ROLE_CLIENT
        ];
    }

    /**
     * @inheritDoc
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @inheritDoc
     */
    public function setPhone($phone)
    {
        $this->phone = (string)$phone;
    }

    /**
     * @inheritDoc
     */
    public function serialize()
    {
        return serialize([$this->id, $this->username, $this->password]);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($serialized)
    {
        list($this->id, $this->username, $this->password) = unserialize($serialized);
    }

    /**
     * @inheritDoc
     */
    public function isEqualTo(UserInterface $user)
    {
        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->salt !== $user->getSalt()) {
            return false;
        }

        if ($this->email !== $user->getUsername()) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function isConditionsAccepted()
    {
        return $this->conditionsAccepted;
    }

    /**
     * @inheritDoc
     */
    public function setConditionsAccepted($conditionsAccepted)
    {
        $this->conditionsAccepted = (bool)$conditionsAccepted;
    }

    /**
     * @inheritDoc
     */
    public function isNewsletterAccepted()
    {
        return $this->newsletterAccepted;
    }

    /**
     * @inheritDoc
     */
    public function setNewsletterAccepted($newsletterAccepted)
    {
        $this->newsletterAccepted = (bool)$newsletterAccepted;
    }

    /**
     * @inheritDoc
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * @inheritDoc
     */
    public function getWishlist()
    {
        return $this->wishlist;
    }

    /**
     * @inheritDoc
     */
    public function setWishlist(Collection $wishlist)
    {
        $this->wishlist = $wishlist;
    }
}
