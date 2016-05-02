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
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface as BaseUserInterface;
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\ShopBundle\Entity\ShopAwareInterface;

/**
 * Interface ClientInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ClientInterface extends
    EntityInterface,
    \Serializable,
    BaseUserInterface,
    EquatableInterface,
    TimestampableInterface,
    BlameableInterface,
    ClientGroupAwareInterface,
    ShopAwareInterface
{
    /**
     * @return Collection
     */
    public function getOrders() : Collection;
    
    /**
     * @return Collection
     */
    public function getWishlist() : Collection;
    
    /**
     * @return ClientDetailsInterface
     */
    public function getClientDetails() : ClientDetailsInterface;
    
    /**
     * @param ClientDetailsInterface $clientDetails
     */
    public function setClientDetails(ClientDetailsInterface $clientDetails);
    
    /**
     * @return ClientContactDetailsInterface
     */
    public function getContactDetails() : ClientContactDetailsInterface;
    
    /**
     * @param ClientContactDetailsInterface $contactDetails
     */
    public function setContactDetails(ClientContactDetailsInterface $contactDetails);
    
    /**
     * @return ClientBillingAddressInterface
     */
    public function getBillingAddress() : ClientBillingAddressInterface;
    
    /**
     * @param ClientBillingAddressInterface $billingAddress
     */
    public function setBillingAddress(ClientBillingAddressInterface $billingAddress);
    
    /**
     * @return ClientShippingAddressInterface
     */
    public function getShippingAddress() : ClientShippingAddressInterface;
    
    /**
     * @param ClientShippingAddressInterface $shippingAddress
     */
    public function setShippingAddress(ClientShippingAddressInterface $shippingAddress);
}
