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

namespace WellCommerce\Bundle\LayeredNavigationBundle\Helper;

use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\Component\DataSet\Conditions\ConditionInterface;
use WellCommerce\Component\DataSet\Conditions\ConditionsCollection;

/**
 * Class LayeredNavigationHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class LayeredNavigationHelper extends AbstractContainerAware implements LayeredNavigationHelperInterface
{
    /**
     * @var array
     */
    private $filters = [];
    
    /**
     * LayeredNavigationHelper constructor.
     *
     * @param array $filters
     */
    public function __construct(array $filters = [])
    {
        $this->setFilters($filters);
    }
    
    public function generateRedirectUrl(): string
    {
        $formParams              = $this->parseFormParameters($this->getRequestHelper()->getRequestBagParam('form', '', FILTER_DEFAULT));
        $route                   = $this->getRequestHelper()->getRequestBagParam('route', 0);
        $currentAttributesParams = $this->getRequestHelper()->getRequestBagParam('route_params', []);
        $currentQueryParams      = $this->getRequestHelper()->getRequestBagParam('query_params', []);
        $currentRouteParams      = array_merge($currentAttributesParams, $currentQueryParams);
        $replacements            = [];
        
        foreach ($this->filters as $parameterName => $configuration) {
            if (isset($formParams[$parameterName])) {
                $value = $formParams[$parameterName];
                if ($configuration['type'] === self::VALUE_TYPE_ARRAY) {
                    $replacements[$parameterName] = empty($value) ? 0 : implode(self::MULTI_VALUE_SEPARATOR, $value);
                } else {
                    $replacements[$parameterName] = $formParams[$parameterName];
                }
            } else {
                $replacements[$parameterName] = 0;
            }
        }
        
        $routeParams = array_replace($currentRouteParams, $replacements);
        
        return $this->getRouterHelper()->generateUrl($route, $routeParams);
    }
    
    public function addLayeredNavigationConditions(ConditionsCollection $collection)
    {
        if (false === $this->isLayeredNavigationEnabled()) {
            return $collection;
        }
        
        foreach ($this->filters as $parameterName => $configuration) {
            $currentAttributeValue = $this->getCurrentAttributeValue($parameterName, $configuration['type']);
            if (!empty($currentAttributeValue)) {
                $collection->add($this->createFilterCondition($currentAttributeValue, $configuration));
            }
        }
        
        return $collection;
    }
    
    public function isLayeredNavigationEnabled(): bool
    {
        $route     = $this->getRouterHelper()->getCurrentRoute();
        $keys      = array_keys($this->filters);
        $isEnabled = false;
        
        foreach ($keys as $key) {
            $value        = $this->getRequestHelper()->getAttributesBagParam($key);
            $defaultValue = null;
            if ($route->hasDefault($key)) {
                $defaultValue = $route->getDefault($key);
            }
            if (null !== $value && $value != $defaultValue) {
                if ($this->filters[$key]['type'] !== self::VALUE_TYPE_ARRAY || ($this->filters[$key]['type'] === self::VALUE_TYPE_ARRAY && $value != 0)) {
                    $isEnabled = true;
                }
            }
        }
        
        return $isEnabled;
    }
    
    private function createFilterCondition($currentAttributeValue, array $configuration): ConditionInterface
    {
        return new $configuration['condition']($configuration['column'], $currentAttributeValue);
    }
    
    private function getCurrentAttributeValue(string $parameterName, string $type)
    {
        if ($type === self::VALUE_TYPE_ARRAY) {
            $parameterValue = $this->getRequestHelper()->getAttributesBagParam($parameterName);
            $parameterValue = explode(self::MULTI_VALUE_SEPARATOR, $parameterValue);
            
            return array_filter($parameterValue, function ($v) {
                return 0 !== (int)$v;
            }, ARRAY_FILTER_USE_BOTH);
        }
        
        return $this->getRequestHelper()->getAttributesBagParam($parameterName);
    }
    
    private function setFilters(array $filters)
    {
        $this->filters = array_filter($filters, function ($v) {
            return (bool)$v['enabled'];
        }, ARRAY_FILTER_USE_BOTH);
    }
    
    private function parseFormParameters(string $queryString): array
    {
        parse_str($queryString, $params);
        
        return $params;
    }
}
