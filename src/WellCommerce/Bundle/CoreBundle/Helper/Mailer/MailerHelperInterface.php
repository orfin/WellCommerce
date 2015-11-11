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

namespace WellCommerce\Bundle\CoreBundle\Helper\Mailer;

use WellCommerce\Bundle\MultiStoreBundle\Entity\ShopInterface;

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
     * @param string             $recipient
     * @param string             $title
     * @param string             $view
     * @param array              $parameters
     * @param ShopInterface|null $shop
     */
    public function sendEmail($recipient, $title, $view, array $parameters = [], ShopInterface $shop = null);
}
