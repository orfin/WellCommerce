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
use Symfony\Component\Security\Core\User\UserInterface;
use WellCommerce\Bundle\CoreBundle\Entity\AddressInterface;
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\ContactDetailsAwareInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;

/**
 * Interface ClientInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ClientInterface extends
    \Serializable,
    UserInterface,
    EquatableInterface,
    TimestampableInterface,
    BlameableInterface,
    ClientGroupAwareInterface,
    ContactDetailsAwareInterface
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
     * @return AddressInterface
     */
    public function getBillingAddress();

    /**
     * @param AddressInterface $billingAddress
     */
    public function setBillingAddress(AddressInterface $billingAddress);

    /**
     * @return AddressInterface
     */
    public function getShippingAddress();

    /**
     * @param AddressInterface $shippingAddress
     */
    public function setShippingAddress(AddressInterface $shippingAddress);
}
