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
 * Class AdminExtension
 *
 * @package WellCommerce\Core\Template\Twig\Extension
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AdminExtension extends \Twig_Extension
{

    protected $container;

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
     * Returns all global assignable admin template variables
     *
     * @return array
     */
    public function getGlobals()
    {
        return [
            'user'     => $this->container->get('session')->get('admin/user'),
            'menu'     => $this->container->get('session')->get('admin/menu'),
            'flashbag' => $this->container->get('session')->getFlashBag()
        ];
    }

    /**
     * Returns unique extensions name
     *
     * @return string
     */
    public function getName()
    {
        return 'admin';
    }
}
