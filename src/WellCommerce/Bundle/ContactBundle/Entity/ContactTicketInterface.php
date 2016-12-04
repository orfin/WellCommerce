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

use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;

/**
 * Class ReviewInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ContactTicketInterface extends EntityInterface
{
    public function getSubject(): string;
    
    public function setSubject(string $subject);
    
    public function getEmail(): string;
    
    public function setEmail(string $email);
    
    public function getContent(): string;
    
    public function setContent(string $content);
}
