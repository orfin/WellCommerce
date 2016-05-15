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
    public function getDiscount() : float;
    
    public function setDiscount(float $discount);
    
    public function setPassword(string $password);

    public function setHashedPassword(string $password);

    public function resetPassword();
    
    public function getUsername() : string;
    
    public function setUsername(string $username);
    
    public function setSalt(string $salt);
    
    public function isConditionsAccepted() : bool;
    
    public function setConditionsAccepted(bool $conditionsAccepted);
    
    public function isNewsletterAccepted() : bool;
    
    public function setNewsletterAccepted(bool $newsletterAccepted);
    
    public function getResetPasswordHash();
    
    public function setResetPasswordHash(string $resetPasswordHash);
}
