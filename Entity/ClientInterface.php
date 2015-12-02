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
use WellCommerce\Bundle\ShopBundle\Entity\ShopAwareInterface;
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;

/**
 * Interface ClientInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ClientInterface extends
    \Serializable,
    BaseUserInterface,
    EquatableInterface,
    TimestampableInterface,
    BlameableInterface,
    ClientGroupAwareInterface,
    ShopAwareInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return float
     */
    public function getDiscount();

    /**
     * @param float $discount
     */
    public function setDiscount($discount);

    /**
     * @param string $password
     */
    public function setPassword($password);

    public function resetPassword();

    /**
     * @param string $username
     */
    public function setUsername($username);

    /**
     * @param string $salt
     */
    public function setSalt($salt);

    /**
     * @return bool
     */
    public function isConditionsAccepted();

    /**
     * @param bool $conditionsAccepted
     */
    public function setConditionsAccepted($conditionsAccepted);

    /**
     * @return bool
     */
    public function isNewsletterAccepted();

    /**
     * @param bool $newsletterAccepted
     */
    public function setNewsletterAccepted($newsletterAccepted);

    /**
     * @return Collection
     */
    public function getOrders();

    /**
     * @return Collection
     */
    public function getWishlist();

    /**
     * @return ClientContactDetailsInterface
     */
    public function getContactDetails();

    /**
     * @param ClientContactDetailsInterface $contactDetails
     */
    public function setContactDetails(ClientContactDetailsInterface $contactDetails);

    /**
     * @return ClientBillingAddressInterface
     */
    public function getBillingAddress();

    /**
     * @param ClientBillingAddressInterface $billingAddress
     */
    public function setBillingAddress(ClientBillingAddressInterface $billingAddress);

    /**
     * @return ClientShippingAddressInterface
     */
    public function getShippingAddress();

    /**
     * @param ClientShippingAddressInterface $shippingAddress
     */
    public function setShippingAddress(ClientShippingAddressInterface $shippingAddress);

    /**
     * @return string
     */
    public function getResetPasswordHash();

    /**
     * @param string $resetPasswordHash
     */
    public function setResetPasswordHash($resetPasswordHash);
}
