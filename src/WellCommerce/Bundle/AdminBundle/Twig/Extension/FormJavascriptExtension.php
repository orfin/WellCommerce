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
namespace WellCommerce\Bundle\AdminBundle\Twig\Extension;

use WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface;
use WellCommerce\Bundle\CoreBundle\Form\Renderer\FormRendererInterface;
use WellCommerce\Bundle\CoreBundle\Twig\AbstractTwigExtension;

/**
 * Class FormJavascriptExtension
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class FormJavascriptExtension extends AbstractTwigExtension
{
    /**
     * @var FormRendererInterface
     */
    protected $renderer;

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
     * Returns extension functions
     *
     * @return \Twig_SimpleFunction[]
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('form_js', [$this, 'render'], ['is_safe' => ['html','javascript']])
        ];
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

    /**
     * Returns extension alias
     *
     * @return string
     */
    public function getName()
    {
        return 'form_js';
    }
}
