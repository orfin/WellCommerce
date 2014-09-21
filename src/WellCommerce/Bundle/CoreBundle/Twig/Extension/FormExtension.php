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

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use WellCommerce\Bundle\CoreBundle\Form\Elements\Form;

/**
 * Class FormExtension
 *
 * Provides form rendering function in Twig
 *
 * @package WellCommerce\Bundle\CoreBundle\Twig\Extension
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FormExtension extends \Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var string
     */
    private $template;

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     * @param string             $template Twig template used to render form
     */
    public function __construct(ContainerInterface $container, $template)
    {
        $this->container = $container;
        $this->template  = $template;
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
        return $this->container->get('templating')->render($this->template, [
            'attributes' => $form->getAttributes(),
            'children'   => $form->renderChildren(),
            'values'     => $form->getValues(),
            'errors'     => $form->getErrors(),
        ]);
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
