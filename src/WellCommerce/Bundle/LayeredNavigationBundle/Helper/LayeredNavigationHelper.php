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
    
    public function generateRedirectUrl() : string
    {
        $formParams              = $this->parseFormParameters($this->getRequestHelper()->getRequestBagParam('form', '', FILTER_DEFAULT));
        $route                   = $this->getRequestHelper()->getRequestBagParam('route', 0);
        $currentAttributesParams = $this->getRequestHelper()->getRequestBagParam('route_params', []);
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
        
        $routeParams = array_replace($currentAttributesParams, $replacements);

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
    
    public function isLayeredNavigationEnabled() : bool
    {
        return $this->getRequestHelper()->hasAttributesBagParams(array_keys($this->filters));
    }
    
    private function createFilterCondition($currentAttributeValue, array $configuration) : ConditionInterface
    {
        return new $configuration['condition']($configuration['column'], $currentAttributeValue);
    }
    
    private function getCurrentAttributeValue(string $parameterName, string $type)
    {
        if ($type === self::VALUE_TYPE_ARRAY) {
            $parameterValue = $this->getRequestHelper()->getAttributesBagParam($parameterName);
            $parameterValue = explode(self::MULTI_VALUE_SEPARATOR, $parameterValue);
            
            return array_filter($parameterValue);
        }
        
        return $this->getRequestHelper()->getAttributesBagParam($parameterName);
    }
    
    private function setFilters(array $filters)
    {
        $this->filters = array_filter($filters, function ($v) {
            return (bool)$v['enabled'];
        }, ARRAY_FILTER_USE_BOTH);
    }
    
    private function parseFormParameters(string $queryString) : array
    {
        parse_str($queryString, $params);
        
        return $params;
    }
}
