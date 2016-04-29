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

namespace WellCommerce\Bundle\SearchBundle\Manager;

use WellCommerce\Bundle\CoreBundle\Manager\AbstractManager;
use WellCommerce\Bundle\CoreBundle\Manager\Front\AbstractFrontManager;
use WellCommerce\Bundle\SearchBundle\Provider\SearchProviderInterface;
use WellCommerce\Bundle\SearchBundle\Query\SimpleQuery;
use WellCommerce\Component\DataSet\Conditions\Condition\In;
use WellCommerce\Component\DataSet\Conditions\ConditionsCollection;

/**
 * Class SearchManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SearchManager extends AbstractManager
{
    /**
     * @var SearchProviderInterface
     */
    protected $provider;

    /**
     * @param SearchProviderInterface $provider
     */
    public function setSearchProvider(SearchProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Adds the search conditions to query
     *
     * @param ConditionsCollection $conditions
     *
     * @return ConditionsCollection
     */
    public function addSearchConditions(ConditionsCollection $conditions)
    {
        $requestHelper = $this->getRequestHelper();
        $phrase        = $requestHelper->getAttributesBagParam('phrase');
        $query         = new SimpleQuery($phrase);
        $identifiers   = $this->provider->searchProducts($query)->getResultIdentifiers();
        $conditions->add(new In('id', $identifiers));

        return $conditions;
    }
}
