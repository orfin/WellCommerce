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

use Swift_Mailer as Mailer;
use Swift_Message as Message;
use Swift_Plugins_LoggerPlugin;
use Swift_Plugins_Loggers_EchoLogger;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\AppBundle\Entity\MailerConfiguration;
use WellCommerce\Bundle\CoreBundle\Helper\Templating\TemplatingHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Validator\ValidatorHelperInterface;

/**
 * Class MailerHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class MailerHelper implements MailerHelperInterface
{
    /**
     * @var TemplatingHelperInterface
     */
    private $templatingHelper;
    
    /**
     * @var ValidatorHelperInterface
     */
    private $validatorHelper;
    
    /**
     * @var array
     */
    private $options = [];
    
    /**
     * @var bool
     */
    private $debug;
    
    /**
     * MailerHelper constructor.
     *
     * @param TemplatingHelperInterface $templatingHelper
     * @param ValidatorHelperInterface  $validatorHelper
     * @param bool                      $debug
     */
    public function __construct(TemplatingHelperInterface $templatingHelper, ValidatorHelperInterface $validatorHelper, bool $debug = false)
    {
        $this->templatingHelper = $templatingHelper;
        $this->validatorHelper  = $validatorHelper;
        $this->debug            = $debug;
    }
    
    public function isEmailValid(string $email): bool
    {
        return $this->validatorHelper->isValid($email, [
            new \Symfony\Component\Validator\Constraints\Email(),
            new \Symfony\Component\Validator\Constraints\NotBlank(),
        ]);
    }
    
    public function sendEmail(array $options): int
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options);
        
        $mailer  = $this->createMailer();
        $message = $this->createMessage();
        
        try {
            return $mailer->send($message);
        } catch (\Exception $e) {
            if ($this->debug) {
                throw $e;
            }
        }
        
        return 0;
    }
    
    private function createMessage(): Message
    {
        $message = Message::newInstance();
        $message->setSubject($this->options['subject']);
        $message->setFrom($this->options['configuration']->getFrom());
        $message->setTo($this->options['recipient']);
        $message->setReplyTo($this->options['reply_to']);
        $message->setBcc($this->options['bcc']);
        
        $this->setBody($message, $this->options['template'], $this->options['parameters']);
        
        foreach ($this->options['attachments'] as $file) {
            $message->attach($this->createAttachment($file));
        }
        
        return $message;
    }
    
    private function createAttachment(string $path): \Swift_Mime_Attachment
    {
        return \Swift_Attachment::fromPath($path);
    }
    
    private function setBody(Message $message, string $template, array $parameters = [])
    {
        $parameters['message'] = $message;
        $body                  = $this->templatingHelper->render($template, $parameters);
        
        $message->setBody($body, 'text/html');
    }
    
    private function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'recipient',
            'bcc',
            'reply_to',
            'subject',
            'template',
            'parameters',
            'configuration',
            'attachments',
        ]);
        
        $resolver->setDefault('bcc', function (Options $options) {
            if ($this->isEmailValid($options['configuration']->getBcc())) {
                return $options['configuration']->getBcc();
            }
            
            return $options['configuration']->getFrom() ?? [];
        });
        
        $resolver->setDefault('reply_to', function (Options $options) {
            return $options['configuration']->getFrom() ?? [];
        });
        
        $resolver->setDefault('attachments', []);
        
        $resolver->setAllowedTypes('recipient', ['string', 'array']);
        $resolver->setAllowedTypes('bcc', ['string', 'array']);
        $resolver->setAllowedTypes('reply_to', ['string', 'array']);
        $resolver->setAllowedTypes('subject', ['string']);
        $resolver->setAllowedTypes('template', ['string']);
        $resolver->setAllowedTypes('parameters', ['array']);
        $resolver->setAllowedTypes('attachments', ['array']);
        $resolver->setAllowedTypes('configuration', MailerConfiguration::class);
    }
    
    private function createMailer(): Mailer
    {
        $configuration = $this->options['configuration'];
        $transport     = new \Swift_SmtpTransport($configuration->getHost(), $configuration->getPort(), 'tls');
        $transport->setUsername($configuration->getUser());
        $transport->setPassword($configuration->getPass());
        $transport->setStreamOptions([
            'ssl' => [
                'verify_peer' => false,
            ],
        ]);
        
        $mailer = Mailer::newInstance($transport);
        
        if ($this->debug) {
            $logger = new Swift_Plugins_Loggers_EchoLogger();
            $mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));
        }
        
        return $mailer;
    }
}
