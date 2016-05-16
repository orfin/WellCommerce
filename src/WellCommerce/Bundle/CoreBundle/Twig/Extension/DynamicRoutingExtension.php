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
use WellCommerce\Bundle\CoreBundle\Helper\Helper;
use WellCommerce\Bundle\CoreBundle\Helper\Request\RequestHelperInterface;

/**
 * Class DynamicRoutingExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class DynamicRoutingExtension extends \Twig_Extension
{
    /**
     * @var UrlGeneratorInterface
     */
    private $generator;
    
    /**
     * @var RequestHelperInterface
     */
    private $requestHelper;
    
    /**
     * DynamicRoutingExtension constructor.
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
            new \Twig_SimpleFunction('isActiveRoute', [$this, 'checkRouteIsActive'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('sortingOptions', [$this, 'getSortingOptions'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('activeSorting', [$this, 'getActiveSortingOption'], ['is_safe' => ['html']]),
        ];
    }
    
    public function getName()
    {
        return 'dynamic_path';
    }
    
    public function getDynamicPath(array $replacements = []) : string
    {
        $route                   = $this->requestHelper->getAttributesBagParam('_route');
        $currentAttributesParams = $this->requestHelper->getAttributesBagParam('_route_params');
        $currentQueryParams      = $this->requestHelper->getCurrentRequest()->query->all();
        $routeParams             = array_replace($currentAttributesParams, $replacements);
        $routeParams             = array_merge($routeParams, $currentQueryParams);
        
        unset($routeParams['_route_object']);

        return $this->generator->generate($route, $routeParams);
    }
    
    public function checkRouteIsActive(string $route) : bool
    {
        $currentRoute = $this->requestHelper->getAttributesBagParam('_route');
        
        return $route === $currentRoute;
    }

    public function getSortingOptions(array $columns = []) : array
    {
        $sorting = [];
        foreach ($columns as $column => $directions) {
            foreach ($directions as $direction) {
                $label  = sprintf('product.options.order_by.%s.%s', Helper::snake($column), $direction);
                $active = $this->isSortingActive($column, $direction);

                $sorting[] = [
                    'orderBy'  => $column,
                    'orderDir' => $direction,
                    'label'    => $label,
                    'active'   => $active
                ];
            }
        }

        return $sorting;
    }

    private function isSortingActive(string $column, string $direction) : bool
    {
        $currentOrderBy  = $this->requestHelper->getAttributesBagParam('orderBy');
        $currentOrderDir = $this->requestHelper->getAttributesBagParam('orderDir');

        return $column === $currentOrderBy && $direction === $currentOrderDir;
    }
}
