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

namespace WellCommerce\Bundle\SearchBundle\Provider;

use WellCommerce\Bundle\SearchBundle\Indexer\ProductIndexerInterface;
use WellCommerce\Bundle\SearchBundle\Manager\SearchIndexManagerInterface;
use WellCommerce\Bundle\SearchBundle\Query\SimpleQuery;

/**
 * Class LuceneSearchProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LuceneProvider implements ResultProviderInterface
{
    /**
     * @var SearchIndexManagerInterface
     */
    protected $searchIndexManager;

    /**
     * @var array
     */
    protected $currentIdentifiers = [];

    /**
     * SearchProvider constructor.
     *
     * @param SearchIndexManagerInterface $searchIndexManager
     */
    public function __construct(SearchIndexManagerInterface $searchIndexManager)
    {
        $this->searchIndexManager = $searchIndexManager;
    }

    /**
     * @param SimpleQuery $simpleQuery
     *
     * @return $this
     */
    public function searchProducts(SimpleQuery $simpleQuery)
    {
        $index   = $this->searchIndexManager->getIndex(ProductIndexerInterface::DEFAULT_INDEX_NAME);
        $results = $index->find($simpleQuery->getSearchPhrase() . '~');

        foreach ($results as $result) {
            if ($result->score >= .1) {
                $this->currentIdentifiers[] = $result->identifier;
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getResultIdentifiers()
    {
        return $this->currentIdentifiers;
    }
}
