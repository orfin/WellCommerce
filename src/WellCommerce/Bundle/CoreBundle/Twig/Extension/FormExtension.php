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
use WellCommerce\Core\Form\Elements\Form;
use WellCommerce\Core\Form\FormInterface;

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
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Returns extension functions
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('form', array(
                $this,
                'render'
            ), array(
                'is_safe' => Array(
                    'html'
                )
            ))
        );
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
        return $this->container->get('twig')->render('form.html.twig', [
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
