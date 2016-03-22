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
 * Class ClientContactDetails
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientDetails implements ClientDetailsInterface
{
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
     * @var float
     */
    protected $discount;

    /**
     * @var bool
     */
    protected $conditionsAccepted;

    /**
     * @var bool
     */
    protected $newsletterAccepted;

    /**
     * @var string
     */
    protected $resetPasswordHash;

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

    public function resetPassword()
    {
        $this->password = null;
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
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return boolean
     */
    public function isConditionsAccepted()
    {
        return $this->conditionsAccepted;
    }

    /**
     * @param boolean $conditionsAccepted
     */
    public function setConditionsAccepted($conditionsAccepted)
    {
        $this->conditionsAccepted = $conditionsAccepted;
    }

    /**
     * @return boolean
     */
    public function isNewsletterAccepted()
    {
        return $this->newsletterAccepted;
    }

    /**
     * @param boolean $newsletterAccepted
     */
    public function setNewsletterAccepted($newsletterAccepted)
    {
        $this->newsletterAccepted = $newsletterAccepted;
    }

    /**
     * @return string
     */
    public function getResetPasswordHash()
    {
        return $this->resetPasswordHash;
    }

    /**
     * @param string $resetPasswordHash
     */
    public function setResetPasswordHash($resetPasswordHash)
    {
        $this->resetPasswordHash = $resetPasswordHash;
    }
}
