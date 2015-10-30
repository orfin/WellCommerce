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

namespace WellCommerce\Bundle\ProductBundle\Manager\Front;

use Doctrine\Common\Collections\Criteria;
use WellCommerce\Bundle\CoreBundle\Manager\Front\AbstractFrontManager;
use WellCommerce\Bundle\CoreBundle\Manager\Front\FrontManagerInterface;
use WellCommerce\Bundle\DataSetBundle\Conditions\Condition\Gte;
use WellCommerce\Bundle\DataSetBundle\Conditions\Condition\In;
use WellCommerce\Bundle\DataSetBundle\Conditions\Condition\Lte;
use WellCommerce\Bundle\DataSetBundle\Conditions\ConditionsCollection;
use WellCommerce\Bundle\ProducerBundle\Entity\ProducerInterface;

/**
 * Class ProductLayeredNavigationManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductLayeredNavigationManager extends AbstractFrontManager implements FrontManagerInterface
{
    const MULTIVALUE_SEPARATOR = '_';

    /**
     * Adds layered's navigation conditions to collection
     *
     * @param ConditionsCollection $collection
     *
     * @return ConditionsCollection
     */
    public function addLayeredNavigationConditions(ConditionsCollection $collection)
    {
        $priceFrom = $this->getRequestHelper()->getAttributesBagParam('priceFrom');
        $priceTo   = $this->getRequestHelper()->getAttributesBagParam('priceTo');
        $producers = array_filter(explode(self::MULTIVALUE_SEPARATOR, $this->getRequestHelper()->getAttributesBagParam('producers')));

        $collection->add(new Gte('finalPrice', $priceFrom));
        $collection->add(new Lte('finalPrice', $priceTo));
        if (count($producers)) {
            $collection->add(new In('producerId', $producers));
        }

        return $collection;
    }

    /**
     * Generates the redirect url used in layered navigation
     *
     * @return string
     */
    public function generateRedirectUrl()
    {
        $formParams              = $this->parseFormParameters($this->getRequestHelper()->getRequestBagParam('form', ''));
        $route                   = $this->getRequestHelper()->getRequestBagParam('route', 0);
        $currentAttributesParams = $this->getRequestHelper()->getRequestBagParam('route_params', []);
        $producers               = isset($formParams['producer']) ? $this->getProducers((array)$formParams['producer']) : [];

        $replacements = [
            'priceFrom' => (int)$formParams['priceFrom'],
            'priceTo'   => (int)$formParams['priceTo'],
            'producers' => implode(self::MULTIVALUE_SEPARATOR, $producers)
        ];

        $routeParams = array_replace($currentAttributesParams, $replacements);

        return $this->getRouterHelper()->generateUrl($route, $routeParams);
    }

    /**
     * Parses the "form" param
     *
     * @param string $parameters
     *
     * @return array
     */
    protected function parseFormParameters($parameters)
    {
        parse_str($parameters, $formParams);

        return $formParams;
    }

    /**
     * Returns an array of producers identifiers if found
     *
     * @param array $identifiers
     *
     * @return array
     */
    protected function getProducers(array $identifiers = [])
    {
        $producers = [];
        $criteria  = new Criteria();
        $criteria->orderBy(['id' => 'asc']);
        $criteria->where($criteria->expr()->in('id', $identifiers));

        $collection = $this->get('producer.repository')->matching($criteria);
        $collection->map(function (ProducerInterface $producer) use (&$producers) {
            $producers[] = $producer->getId();
        });

        return $producers;
    }


}
