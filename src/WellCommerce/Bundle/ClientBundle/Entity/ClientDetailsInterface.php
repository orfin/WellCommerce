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

/**
 * Interface ClientContactDetailsInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ClientDetailsInterface
{
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
     * @return void
     */
    public function resetPassword();

    /**
     * @return string
     */
    public function getUsername();

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
     * @return string
     */
    public function getResetPasswordHash();

    /**
     * @param string $resetPasswordHash
     */
    public function setResetPasswordHash($resetPasswordHash);
}
