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

namespace WellCommerce\Bundle\CoreBundle\Service\Mailer;

/**
 * Class MailMessage
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MailMessage implements MailMessageInterface
{
    public function __construct(string $subject, string $sender, string $recipient)
    {
    }
    
    public function setSubject(string $subject)
    {
        $this->subject = $subject;
        
        return $this;
    }
}
