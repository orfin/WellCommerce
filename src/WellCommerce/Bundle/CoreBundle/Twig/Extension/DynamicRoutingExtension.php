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

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Request\RequestHelperInterface;

/**
 * Class DynamicRoutingExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DynamicRoutingExtension extends \Twig_Extension
{
    /**
     * @var UrlGeneratorInterface
     */
    protected $generator;

    /**
     * @var RequestHelperInterface
     */
    protected $requestHelper;

    /**
     * Constructor
     *
     * @param UrlGeneratorInterface  $generator
     * @param RequestHelperInterface $requestHelper
     */
    public function __construct(UrlGeneratorInterface $generator, RequestHelperInterface $requestHelper)
    {
        $this->generator     = $generator;
        $this->requestHelper = $requestHelper;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('dynamic_path', [$this, 'getDynamicPath'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'dynamic_path';
    }

    /**
     * Generates a dynamic route with replaced parameters
     *
     * @param array $replacements
     *
     * @return string
     */
    public function getDynamicPath(array $replacements = [])
    {
        $route                   = $this->requestHelper->getAttributesBagParam('_route');
        $currentAttributesParams = $this->requestHelper->getAttributesBagParam('_route_params');
        $currentQueryParams      = $this->requestHelper->getCurrentRequest()->query->all();
        $routeParams             = array_replace($currentAttributesParams, $replacements);
        $routeParams             = array_merge($routeParams, $currentQueryParams);

        return $this->generator->generate($route, $routeParams);
    }
}
