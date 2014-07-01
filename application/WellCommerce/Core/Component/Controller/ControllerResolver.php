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
namespace WellCommerce\Core\Component\Controller;

use Symfony\Component\HttpKernel\Controller\ControllerResolver as BaseControllerResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ControllerResolver
 *
 * @package WellCommerce\Core\Component\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ControllerResolver extends BaseControllerResolver
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * @var string Action name
     */
    protected $action;

    /**
     * @var string Controller name
     */
    protected $baseController;

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param string $class
     *
     * @return array|mixed
     * @throws \InvalidArgumentException
     */
    protected function createController($class)
    {
        list($service, $method) = explode(':', $class, 2);

        return [
            $this->container->get($service),
            $method
        ];
    }
}
