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

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;

/**
 * Interface ClientInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ClientInterface extends \Serializable, UserInterface, EquatableInterface, TimestampableInterface, BlameableInterface
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
     * @return ArrayCollection
     */
    public function getAddresses();

    /**
     * @param ArrayCollection $addresses
     */
    public function setAddresses(ArrayCollection $addresses);

    /**
     * @param ClientAddress $address
     */
    public function addAddress(ClientAddress $address);

    /**
     * @return ClientGroup
     */
    public function getGroup();

    /**
     * @param ClientGroup $clientGroup
     */
    public function setGroup(ClientGroup $clientGroup);

    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName);

    /**
     * @return string
     */
    public function getLastName();

    /**
     * @param string $lastName
     */
    public function setLastName($lastName);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param string $email
     */
    public function setEmail($email);

    /**
     * @param string $password
     */
    public function setPassword($password);

    /**
     * @param string $salt
     */
    public function setSalt($salt);

    /**
     * @param string $username
     */
    public function setUsername($username);

    /**
     * @return string
     */
    public function getPhone();

    /**
     * @param string $phone
     */
    public function setPhone($phone);

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
}
