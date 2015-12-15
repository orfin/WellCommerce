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

use WellCommerce\Bundle\CoreBundle\Helper\Request\RequestHelperInterface;

/**
 * Class RoutingHelperExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RoutingHelperExtension extends \Twig_Extension
{
    /**
     * @var RequestHelperInterface
     */
    protected $requestHelper;

    /**
     * Constructor
     *
     * @param RequestHelperInterface $requestHelper
     */
    public function __construct(RequestHelperInterface $requestHelper)
    {
        $this->requestHelper = $requestHelper;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('isActiveRoute', [$this, 'checkRouteIsActive'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'routing_helper';
    }

    /**
     * Checks whether passed route is the same as in request
     *
     * @param string $route
     *
     * @return bool
     */
    public function checkRouteIsActive($route)
    {
        $currentRoute = $this->requestHelper->getAttributesBagParam('_route');

        return $route === $currentRoute;
    }
}
