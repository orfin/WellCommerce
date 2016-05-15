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
    
    public function getDiscount() : float
    {
        return $this->discount;
    }
    
    public function setDiscount(float $discount)
    {
        $this->discount = $discount;
    }
    
    public function getPassword() : string
    {
        return $this->password;
    }
    
    public function setPassword(string $password)
    {
        $this->password = $password;
    }
    
    public function resetPassword()
    {
        $this->password = null;
    }
    
    public function setHashedPassword(string $password)
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }
    
    public function getSalt()
    {
        return null;
    }
    
    public function setSalt(string $salt)
    {
        $this->salt = $salt;
    }
    
    public function getUsername() : string
    {
        return $this->username;
    }
    
    public function setUsername(string $username)
    {
        $this->username = $username;
    }
    
    public function isConditionsAccepted() : bool
    {
        return $this->conditionsAccepted;
    }
    
    public function setConditionsAccepted(bool $conditionsAccepted)
    {
        $this->conditionsAccepted = $conditionsAccepted;
    }
    
    public function isNewsletterAccepted() : bool
    {
        return $this->newsletterAccepted;
    }
    
    public function setNewsletterAccepted(bool $newsletterAccepted)
    {
        $this->newsletterAccepted = $newsletterAccepted;
    }
    
    public function getResetPasswordHash()
    {
        return $this->resetPasswordHash;
    }
    
    public function setResetPasswordHash(string $resetPasswordHash)
    {
        $this->resetPasswordHash = $resetPasswordHash;
    }
}
