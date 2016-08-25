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
namespace WellCommerce\Bundle\CoreBundle\Twig\Extension;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use WellCommerce\Bundle\CoreBundle\Event\Code\TwigTemplateCodeInterface;
use WellCommerce\Bundle\CoreBundle\Event\Code\TwigTemplateInclude;
use WellCommerce\Bundle\CoreBundle\Event\Code\TwigTemplateString;
use WellCommerce\Bundle\CoreBundle\Event\TemplateEvent;

/**
 * Class EventExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class EventExtension extends \Twig_Extension
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;
    
    /**
     * EventExtension constructor.
     *
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
    
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('event', [$this, 'dispatchEvent'], [
                    'needs_environment' => true,
                    'needs_context'     => true,
                    'is_safe'           => ['html', 'javascript']
                ]
            ),
        ];
    }
    
    public function dispatchEvent(\Twig_Environment $env, $context, string $name, array $parameters = [])
    {
        $event = new TemplateEvent();
        $this->dispatcher->dispatch($name, $event);
        
        return $this->render($env, $context, $event);
    }
    
    private function render(\Twig_Environment $env, $context, TemplateEvent $event)
    {
        $codes    = $event->getCodes();
        $compiled = '';
        
        $codes->map(function (TwigTemplateCodeInterface $code) use (&$compiled, $env, $context) {
            if ($code instanceof TwigTemplateString) {
                $template = $env->createTemplate($code->getTemplateString());
                $compiled .= $template->render(array_replace_recursive($context, $code->getParameters()));
            }
            if ($code instanceof TwigTemplateInclude) {
                $compiled .= $env->resolveTemplate($code->getTemplate())->render(array_replace_recursive($context, $code->getParameters()));
            }
        });
        
        return $compiled;
    }
    
    public function getName()
    {
        return 'event';
    }
}
