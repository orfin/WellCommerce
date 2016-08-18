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
 * Class FormExtension
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
final class FormExtension extends \Twig_Extension
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
            new \Twig_SimpleFunction('render_form', [$this, 'renderForm'], ['is_safe' => ['html', 'javascript']]),
            new \Twig_SimpleFunction('render_form_javascript', [$this, 'renderFormJavascript'], ['is_safe' => ['html', 'javascript']])
        ];
    }
    
    public function renderForm(FormInterface $form) : string
    {
        return $this->environment->render($this->renderer->getTemplateName(), [
            'form' => $form
        ]);
    }
    
    public function renderFormJavascript(FormInterface $form) : string
    {
        return $this->renderer->renderForm($form);
    }
    
    public function getName()
    {
        return 'form';
    }
}
