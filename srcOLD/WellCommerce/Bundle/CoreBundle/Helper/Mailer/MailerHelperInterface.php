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

use WellCommerce\Bundle\AppBundle\Entity\MailerConfiguration;

/**
 * Interface MailerHelperInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface MailerHelperInterface
{

    /**
     * Sends an email
     *
     * @param string              $recipient
     * @param string              $title
     * @param string              $template
     * @param array               $parameters
     * @param MailerConfiguration $mailerConfiguration
     */
    public function sendEmail($recipient, $title, $template, array $parameters = [], MailerConfiguration $mailerConfiguration);
}
