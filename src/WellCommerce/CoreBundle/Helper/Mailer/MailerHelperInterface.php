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

namespace WellCommerce\CoreBundle\Helper\Mailer;

use WellCommerce\CommonBundle\Entity\ShopInterface;

/**
 * Interface MailerHelperInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface MailerHelperInterface
{
    /**
     * Sends an e-mail message
     *
     * @param string         $recipient
     * @param string         $title
     * @param string         $body
     * @param ShopInterface| $shop
     */
    public function sendEmail($recipient, $title, $body, ShopInterface $shop);
}
