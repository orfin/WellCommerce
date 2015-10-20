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
use WellCommerce\Bundle\CoreBundle\Entity\AddressInterface;
use WellCommerce\Bundle\CoreBundle\Entity\ContactDetailsTrait;

/**
 * Class Client
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Client implements ClientInterface
{
    const ROLE_CLIENT = 'ROLE_CLIENT';

    use Timestampable;
    use Blameable;
    use ContactDetailsTrait;

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
    protected $password;

    /**
     * @var string
     */
    protected $username;

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
     * @var AddressInterface
     */
    protected $billingAddress;

    /**
     * @var AddressInterface
     */
    protected $shippingAddress;

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

        if ($this->username !== $user->getUsername()) {
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
     * {@inheritdoc}
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function setBillingAddress(AddressInterface $billingAddress)
    {
        $this->billingAddress = $billingAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function setShippingAddress(AddressInterface $shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }
}
