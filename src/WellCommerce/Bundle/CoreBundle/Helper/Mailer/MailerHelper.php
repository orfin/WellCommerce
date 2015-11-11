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
use Symfony\Component\Templating\EngineInterface;
use WellCommerce\Bundle\CoreBundle\Entity\MailerConfiguration;

/**
 * Class MailerHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MailerHelper implements MailerHelperInterface
{
    /**
     * @var EngineInterface
     */
    protected $engine;

    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * Constructor
     *
     * @param EngineInterface $engine
     * @param \Swift_Mailer   $mailer
     */
    public function __construct(EngineInterface $engine, \Swift_Mailer $mailer)
    {
        $this->engine = $engine;
        $this->mailer = $mailer;
    }

    /**
     * {@inheritdoc}
     */
    public function sendEmail($recipient, $title, $view, array $parameters = [], MailerConfiguration $mailerConfiguration = null)
    {
        $body = $this->prepareMessage($view, $parameters);

        $message = Message::newInstance()
            ->setSubject($title)
            ->setFrom('adam@wellcommerce.org')
            ->setTo($recipient)
            ->setBody($body, 'text/html');

        if (null !== $mailerConfiguration) {
            $this->mailer = $this->changeConfiguration($mailerConfiguration);
        }

        return $this->mailer->send($message);
    }

    /**
     * Changes mailer configuration on runtime
     *
     * @param MailerConfiguration $mailerConfiguration
     *
     * @return \Swift_Mailer
     */
    protected function changeConfiguration(MailerConfiguration $mailerConfiguration)
    {
        $transport = new \Swift_SmtpTransport();
        $transport->setHost($mailerConfiguration->getHost());
        $transport->setPort($mailerConfiguration->getPort());
        $transport->setUsername($mailerConfiguration->getUser());
        $transport->setPassword($mailerConfiguration->getPass());

        return $this->mailer->newInstance($transport);
    }

    /**
     * Returns the rendered message
     *
     * @param string $view
     * @param array  $parameters
     *
     * @return string
     */
    protected function prepareMessage($view, array $parameters = [])
    {
        return $this->engine->render($view, $parameters);
    }
}
