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
namespace WellCommerce\Core\Template\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class FormExtension
 *
 * Provides form rendering function in Twig
 *
 * @package WellCommerce\Core\Template\Twig\Extension
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FormExtension extends \Twig_Extension
{

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

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

    public function render($form)
    {
        return $form->render();
    }

    public function getName()
    {
        return 'form';
    }
}
