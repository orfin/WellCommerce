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
use ZendSearch\Lucene\Index\Term;
use ZendSearch\Lucene\Search\Query\Fuzzy;

/**
 * Class LuceneProductSearchProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LuceneProductSearchProvider implements ProductSearchProviderInterface
{
    /**
     * @var SearchIndexManagerInterface
     */
    protected $searchIndexManager;

    /**
     * ProductSearchProvider constructor.
     *
     * @param SearchIndexManagerInterface $searchIndexManager
     */
    public function __construct(SearchIndexManagerInterface $searchIndexManager)
    {
        $this->searchIndexManager = $searchIndexManager;
    }

    /**
     * {@inheritdoc}
     */
    public function searchProducts(SimpleQuery $query)
    {
        $index       = $this->searchIndexManager->getIndex(ProductIndexerInterface::DEFAULT_INDEX_NAME);
        $term        = new Term($query->getSearchPhrase());
        $query       = new Fuzzy($term);
        $results     = $index->find($query);
        $identifiers = [];

        foreach ($results as $result) {
            $identifiers[] = $result->identifier;
        }

        return $identifiers;
    }
}
