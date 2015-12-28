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
class FormJavascriptExtension extends \Twig_Extension
{
    /**
     * @var FormRendererInterface
     */
    protected $renderer;

    /**
     * @var \Twig_Environment
     */
    protected $environment;

    /**
     * Constructor
     *
     * @param FormRendererInterface $renderer
     */
    public function __construct(FormRendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Initializes Twig
     *
     * @param \Twig_Environment $environment
     */
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * Returns extension functions
     *
     * @return \Twig_SimpleFunction[]
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('form_js', [$this, 'render'], ['is_safe' => ['html', 'javascript']])
        ];
    }

    /**
     * Returns extension alias
     *
     * @return string
     */
    public function getName()
    {
        return 'form_js';
    }

    /**
     * Renders the javascript part
     *
     * @param FormInterface $form
     *
     * @return string
     */
    public function render(FormInterface $form)
    {
        $templateVars = [
            'form'            => $form,
            'form_javascript' => $this->renderer->renderForm($form),
        ];

        return $this->environment->render($this->renderer->getTemplateName(), $templateVars);
    }
}
