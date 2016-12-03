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

namespace WellCommerce\Bundle\ContactBundle\Entity;

use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\CoreBundle\Entity\IdentifiableTrait;

/**
 * Class ContactTicket
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactTicket implements ContactTicketInterface
{
    use IdentifiableTrait;
    use Timestampable;
    
    protected $name    = '';
    protected $surname = '';
    protected $subject = '';
    protected $phone   = '';
    protected $email   = '';
    protected $content = '';
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function setName(string $name)
    {
        $this->name = $name;
    }
    
    public function getSurname(): string
    {
        return $this->surname;
    }
    
    public function setSurname(string $surname)
    {
        $this->surname = $surname;
    }
    
    public function getSubject(): string
    {
        return $this->subject;
    }
    
    public function setSubject(string $subject)
    {
        $this->subject = $subject;
    }
    
    public function getPhone(): string
    {
        return $this->phone;
    }
    
    public function setPhone(string $phone)
    {
        $this->phone = $phone;
    }
    
    public function getEmail(): string
    {
        return $this->email;
    }
    
    public function setEmail(string $email)
    {
        $this->email = $email;
    }
    
    public function getContent(): string
    {
        return $this->content;
    }
    
    public function setContent(string $content)
    {
        $this->content = $content;
    }
}
