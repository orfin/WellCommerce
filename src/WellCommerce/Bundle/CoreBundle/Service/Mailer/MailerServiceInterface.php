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
 * Interface MailerServiceInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface MailerServiceInterface
{
    /**
     * Sends an email
     *
     * @param array $options
     *
     * @return int
     */
    public function sendEmail(array $options) : int;
}
