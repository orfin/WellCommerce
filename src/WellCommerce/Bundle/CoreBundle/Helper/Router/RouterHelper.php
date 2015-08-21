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

namespace WellCommerce\Bundle\CoreBundle\Helper\Router;

use ReflectionClass;
use ReflectionMethod;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class RouterHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RouterHelper implements RouterHelperInterface
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * Constructor
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function hasControllerAction($controller, $action)
    {
        $reflectionClass = new ReflectionClass($controller);
        if ($reflectionClass->hasMethod($action)) {
            $reflectionMethod = new ReflectionMethod($controller, $action);
            if ($reflectionMethod->isPublic()) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentAction()
    {
        $currentPath  = $this->getRouterRequestContext()->getPathInfo();
        $currentRoute = $this->router->match($currentPath);
        list(, $action) = explode(':', $currentRoute['_controller']);

        return $action;
    }

    /**
     * {@inheritdoc}
     */
    public function getRouterRequestContext()
    {
        return $this->router->getContext();
    }
}
