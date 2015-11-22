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

namespace WellCommerce\AppBundle\Helper\Mailer;

use Swift_Message as Message;
use WellCommerce\AppBundle\Entity\MailerConfiguration;

/**
 * Class MailerHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MailerHelper implements MailerHelperInterface
{
    /**
     * {@inheritdoc}
     */
    public function sendEmail($recipient, $title, $body, MailerConfiguration $mailerConfiguration)
    {
        $mailer = $this->createMailer($mailerConfiguration);

        $message = Message::newInstance()
            ->setSubject($title)
            ->setFrom($mailerConfiguration->getFrom())
            ->setTo($recipient)
            ->setBody($body, 'text/html');

        return $mailer->send($message);
    }

    /**
     * Changes mailer configuration on runtime
     *
     * @param MailerConfiguration $mailerConfiguration
     *
     * @return \Swift_Mailer
     */
    protected function createMailer(MailerConfiguration $mailerConfiguration)
    {
        $transport = new \Swift_SmtpTransport();
        $transport->setHost($mailerConfiguration->getHost());
        $transport->setPort($mailerConfiguration->getPort());
        $transport->setUsername($mailerConfiguration->getUser());
        $transport->setPassword($mailerConfiguration->getPass());

        return \Swift_Mailer::newInstance($transport);
    }
}
