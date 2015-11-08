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

use WellCommerce\Bundle\CoreBundle\Manager\Front\AbstractFrontManager;
use WellCommerce\Bundle\DataSetBundle\Conditions\Condition\In;
use WellCommerce\Bundle\DataSetBundle\Conditions\ConditionsCollection;
use WellCommerce\Bundle\SearchBundle\Provider\ProductSearchProviderInterface;
use WellCommerce\Bundle\SearchBundle\Query\SimpleQuery;

/**
 * Class ProductSearchManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductSearchManager extends AbstractFrontManager
{
    /**
     * @var ProductSearchProviderInterface
     */
    protected $provider;

    /**
     * @param ProductSearchProviderInterface $provider
     */
    public function setProductSearchProvider(ProductSearchProviderInterface $provider)
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
        $identifiers   = $this->provider->searchProducts($query);
        $conditions->add(new In('id', $identifiers));

        return $conditions;
    }
}
