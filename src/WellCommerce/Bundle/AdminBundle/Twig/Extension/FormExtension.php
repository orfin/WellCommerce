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
use WellCommerce\Bundle\CoreBundle\Form\Renderer\FormRendererChainInterface;
use WellCommerce\Bundle\CoreBundle\Form\Renderer\FormRendererFactory;
use WellCommerce\Bundle\CoreBundle\Twig\AbstractTwigExtension;

/**
 * Class FormExtension
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class FormExtension extends AbstractTwigExtension
{
    /**
     * @var FormRendererChainInterface
     */
    protected $formRendererChain;

    /**
     * Constructor
     *
     * @param FormRendererChainInterface $formRendererChain
     */
    public function __construct(FormRendererChainInterface $formRendererChain)
    {
        $this->formRendererChain = $formRendererChain;
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
     * @param FormInterface $form
     * @param string        $type
     *
     * @return string
     */
    public function render(FormInterface $form, $type = 'js')
    {
        $renderer = $this->formRendererChain->guessRenderer($type);
        $renderer->render($form);

        $templateVars = [
            'form'     => $form,
            'children' => $renderer->render($form),
            //            'values'   => $form->getValues(),
            //            'errors'   => $form->getErrors(),
            'values'   => [],
            'errors'   => [],
        ];

        return $this->environment->render($renderer->getTemplateName(), $templateVars);
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
