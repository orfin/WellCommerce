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

namespace WellCommerce\Bundle\ProductBundle\Helper;

use Doctrine\Common\Collections\Criteria;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\Bundle\DataSetBundle\Conditions\Condition\Gte;
use WellCommerce\Bundle\DataSetBundle\Conditions\Condition\In;
use WellCommerce\Bundle\DataSetBundle\Conditions\Condition\Lte;
use WellCommerce\Bundle\DataSetBundle\Conditions\ConditionsCollection;
use WellCommerce\Bundle\ProducerBundle\Entity\ProducerInterface;
use WellCommerce\Bundle\ProducerBundle\Repository\ProducerRepositoryInterface;

/**
 * Interface ProductLayeredNavigationHelperInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductLayeredNavigationHelper extends AbstractContainerAware implements ProductLayeredNavigationHelperInterface
{
    /**
     * @var ProducerRepositoryInterface
     */
    protected $producerRepository;

    /**
     * @var array
     */
    protected $requiredAttributes = ['priceFrom', 'priceTo', 'producers', 'attributes'];

    /**
     * Constructor
     *
     * @param ProducerRepositoryInterface $producerRepository
     */
    public function __construct(ProducerRepositoryInterface $producerRepository)
    {
        $this->producerRepository = $producerRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function generateRedirectUrl()
    {
        $formParams              = $this->parseFormParameters($this->getRequestHelper()->getRequestBagParam('form', '', FILTER_DEFAULT));
        $route                   = $this->getRequestHelper()->getRequestBagParam('route', 0);
        $currentAttributesParams = $this->getRequestHelper()->getRequestBagParam('route_params', []);
        $producers               = isset($formParams['producer']) ? $this->filterProducers((array)$formParams['producer']) : [];

        $replacements = [
            'priceFrom' => (int)$formParams['priceFrom'],
            'priceTo'   => (int)$formParams['priceTo'],
            'producers' => $this->getProducersRouteParam($producers)
        ];

        $routeParams = array_replace($currentAttributesParams, $replacements);

        return $this->getRouterHelper()->generateUrl($route, $routeParams);
    }

    /**
     * Returns the producers string or null
     *
     * @param array $producers
     *
     * @return null|string
     */
    protected function getProducersRouteParam(array $producers = [])
    {
        if (count($producers) > 0) {
            return implode(ProductLayeredNavigationHelperInterface::MULTIVALUE_SEPARATOR, $producers);
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function addLayeredNavigationConditions(ConditionsCollection $collection)
    {
        if (false === $this->isLayeredNavigationEnabled()) {
            return $collection;
        }

        $priceFrom            = $this->getRequestHelper()->getAttributesBagParam('priceFrom');
        $priceTo              = $this->getRequestHelper()->getAttributesBagParam('priceTo');
        $producersIdentifiers = explode(self::MULTIVALUE_SEPARATOR, $this->getRequestHelper()->getAttributesBagParam('producers'));
        $producers            = $this->filterProducers($producersIdentifiers);

        $collection->add(new Gte('finalPrice', $priceFrom));
        $collection->add(new Lte('finalPrice', $priceTo));
        if (count($producers)) {
            $collection->add(new In('producerId', $producers));
        }

        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function isLayeredNavigationEnabled()
    {
        return $this->getRequestHelper()->hasAttributesBagParams($this->requiredAttributes);
    }

    /**
     * {@inheritdoc}
     */
    public function filterProducers(array $identifiers = [])
    {
        $producers  = [];
        $collection = $this->getProducerCollection($identifiers);
        $collection->map(function (ProducerInterface $producer) use (&$producers) {
            $producers[] = $producer->getId();
        });

        return $producers;
    }

    /**
     * Returns the collection of producers for given identifiers
     *
     * @param array $identifiers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    protected function getProducerCollection(array $identifiers = [])
    {
        $criteria = new Criteria();
        $criteria->orderBy(['id' => 'asc']);
        $criteria->where($criteria->expr()->in('id', $identifiers));

        return $this->producerRepository->matching($criteria);
    }

    /**
     * {@inheritdoc}
     */
    public function filterAttributes(array $identifiers = [])
    {

    }

    /**
     * Parses the given query string parameters
     *
     * @param string $queryString
     *
     * @return array
     */
    protected function parseFormParameters($queryString)
    {
        parse_str($queryString, $params);

        return $params;
    }
}
