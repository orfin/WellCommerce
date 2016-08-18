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

use WellCommerce\Component\Form\Elements\FormInterface;
use WellCommerce\Component\Form\Renderer\FormRendererInterface;

/**
 * Class FormJavascriptExtension
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
final class FormJavascriptExtension extends \Twig_Extension
{
    /**
     * @var FormRendererInterface
     */
    private $renderer;
    
    /**
     * @var \Twig_Environment
     */
    private $environment;
    
    /**
     * FormJavascriptExtension constructor.
     *
     * @param FormRendererInterface $renderer
     */
    public function __construct(FormRendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }
    
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }
    
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('form_js', [$this, 'render'], ['is_safe' => ['html', 'javascript']]),
            new \Twig_SimpleFunction('form_javascript', [$this, 'renderJavascript'], ['is_safe' => ['html', 'javascript']])
        ];
    }
    
    public function getName()
    {
        return 'form_js';
    }
    
    public function render(FormInterface $form) : string
    {
        $templateVars = [
            'form' => $form
        ];
        
        return $this->environment->render($this->renderer->getTemplateName(), $templateVars);
    }
    
    public function renderJavascript(FormInterface $form) : string
    {
        return $this->renderer->renderForm($form);
    }
}
