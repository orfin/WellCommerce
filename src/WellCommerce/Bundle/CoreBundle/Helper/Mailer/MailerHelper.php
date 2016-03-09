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

use Swift_Message as Message;
use WellCommerce\Bundle\AppBundle\Entity\MailerConfiguration;
use WellCommerce\Bundle\CoreBundle\Helper\Templating\TemplatingHelperInterface;

/**
 * Class MailerHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MailerHelper implements MailerHelperInterface
{
    /**
     * @var TemplatingHelperInterface
     */
    protected $templatingHelper;

    /**
     * MailerHelper constructor.
     *
     * @param TemplatingHelperInterface $templatingHelper
     */
    public function __construct(TemplatingHelperInterface $templatingHelper)
    {
        $this->templatingHelper = $templatingHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function sendEmail($recipient, $title, $template, array $parameters = [], MailerConfiguration $mailerConfiguration)
    {
        $mailer  = $this->createMailer($mailerConfiguration);
        $message = Message::newInstance();

        $message->setSubject($title);
        $message->setFrom($mailerConfiguration->getFrom());
        $message->setTo($recipient);

        $this->setBody($message, $template, $parameters);

        return $mailer->send($message);
    }

    protected function setBody(Message $message, $template, array $parameters = [])
    {
        $parameters['message'] = $message;
        $body                  = $this->templatingHelper->render($template, $parameters);

        $message->setBody($body, 'text/html');
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
