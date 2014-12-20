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

use WellCommerce\Bundle\CoreBundle\Form\Elements\Form;

/**
 * Class FormExtension
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class FormExtension extends \Twig_Extension
{
    /**
     * @var \Twig_Environment
     */
    protected $environment;

    /**
     * @var string Template name
     */
    protected $templateName;

    /**
     * Constructor
     *
     * @param $templateName
     */
    public function __construct($templateName)
    {
        $this->templateName = $templateName;
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
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('form', [$this, 'render'], ['is_safe' => ['html']])
        ];
    }

    /**
     * Renders the form
     *
     * @param Form $form
     *
     * @return mixed
     */
    public function render(Form $form)
    {
        $templateVars = $this->extractFormVariables($form);

        return $this->environment->render($this->templateName, $templateVars);
    }

    /**
     * Extracts form configuration
     *
     * @param Form $form
     *
     * @return array
     */
    protected function extractFormVariables(Form $form)
    {
        return [
            'attributes' => $form->getAttributes(),
            'children'   => $form->renderChildren(),
            'values'     => $form->getValues(),
            'errors'     => $form->getErrors(),
        ];
    }

    /**
     * Returns extension alias
     *
     * @return string
     */
    public function getName()
    {
        return 'form';
    }
}
