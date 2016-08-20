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
use Symfony\Component\Security\Core\User\UserInterface as BaseUserInterface;
use WellCommerce\Bundle\CoreBundle\Entity\IdentifiableTrait;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\ShopBundle\Entity\ShopAwareTrait;

/**
 * Class Client
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Client implements ClientInterface
{
    const ROLE_CLIENT = 'ROLE_CLIENT';

    use IdentifiableTrait;
    use Timestampable;
    use Blameable;
    use ShopAwareTrait;
    use ClientGroupAwareTrait;
    
    /**
     * @var Collection
     */
    protected $orders;
    
    /**
     * @var Collection
     */
    protected $wishlist;
    
    /**
     * @var ClientDetails
     */
    protected $clientDetails;
    
    /**
     * @var ClientContactDetailsInterface
     */
    protected $contactDetails;
    
    /**
     * @var ClientBillingAddressInterface
     */
    protected $billingAddress;
    
    /**
     * @var ClientShippingAddressInterface
     */
    protected $shippingAddress;
    
    public function getPassword()
    {
        return $this->clientDetails->getPassword();
    }
    
    public function getSalt()
    {
        return $this->clientDetails->getSalt();
    }
    
    public function getUsername()
    {
        return $this->clientDetails->getUsername();
    }
    
    public function eraseCredentials()
    {
    }
    
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
        return serialize([$this->id, $this->getUsername(), $this->getPassword()]);
    }
    
    public function unserialize($serialized)
    {
        list($this->id, $username, $password) = unserialize($serialized);
        if (!$this->clientDetails instanceof ClientDetailsInterface) {
            $this->clientDetails = new ClientDetails();
        }
        $this->clientDetails->setUsername($username);
        $this->clientDetails->setPassword($password);
    }
    
    public function isEqualTo(BaseUserInterface $user)
    {
        if ($this->getPassword() !== $user->getPassword()) {
            return false;
        }
        
        if ($this->getSalt() !== $user->getSalt()) {
            return false;
        }
        
        if ($this->getUsername() !== $user->getUsername()) {
            return false;
        }
        
        return true;
    }
    
    public function getOrders() : Collection
    {
        return $this->orders->filter(function (OrderInterface $order) {
            return $order->isConfirmed();
        });
    }
    
    public function getWishlist() : Collection
    {
        return $this->wishlist;
    }
    
    public function getClientDetails() : ClientDetailsInterface
    {
        return $this->clientDetails;
    }
    
    public function setClientDetails(ClientDetailsInterface $clientDetails)
    {
        $this->clientDetails = $clientDetails;
    }
    
    public function getContactDetails() : ClientContactDetailsInterface
    {
        return $this->contactDetails;
    }
    
    public function setContactDetails(ClientContactDetailsInterface $contactDetails)
    {
        $this->contactDetails = $contactDetails;
    }
    
    public function getBillingAddress() : ClientBillingAddressInterface
    {
        return $this->billingAddress;
    }
    
    public function setBillingAddress(ClientBillingAddressInterface $billingAddress)
    {
        $this->billingAddress = $billingAddress;
    }
    
    public function getShippingAddress() : ClientShippingAddressInterface
    {
        return $this->shippingAddress;
    }
    
    public function setShippingAddress(ClientShippingAddressInterface $shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }
}
