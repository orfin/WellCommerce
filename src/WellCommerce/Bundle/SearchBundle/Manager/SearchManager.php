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

use Symfony\Component\Console\Output\OutputInterface;
use WellCommerce\Bundle\SearchBundle\Indexer\IndexerInterface;
use WellCommerce\Bundle\SearchBundle\Provider\ResultProviderInterface;
use WellCommerce\Bundle\SearchBundle\Query\SearchQuery;

/**
 * Class SearchManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class SearchManager implements SearchManagerInterface
{
    /**
     * @var IndexerInterface
     */
    private $indexer;
    
    /**
     * @var ResultProviderInterface
     */
    private $resultProvider;

    /**
     * @var array
     */
    private $resultIdentifiers = [];

    /**
     * SearchManager constructor.
     *
     * @param IndexerInterface        $indexer
     * @param ResultProviderInterface $resultProvider
     */
    public function __construct(IndexerInterface $indexer, ResultProviderInterface $resultProvider)
    {
        $this->indexer        = $indexer;
        $this->resultProvider = $resultProvider;
    }

    public function getIndexer() : IndexerInterface
    {
        return $this->indexer;
    }

    public function getProvider() : ResultProviderInterface
    {
        return $this->resultProvider;
    }

    public function createIndex()
    {
        $this->indexer->create();
    }
    
    public function getIndex()
    {
        return $this->indexer->get();
    }
    
    public function removeIndex()
    {
        $this->indexer->remove();
    }
    
    public function eraseIndex()
    {
        $this->indexer->erase();
    }
    
    public function reindex()
    {
        $this->indexer->reindex();
    }

    public function search(SearchQuery $query) : array
    {
        $this->resultIdentifiers = $this->resultProvider->search($query);

        return $this->resultIdentifiers;
    }

    public function getResultIdentifiers() : array
    {
        return $this->resultIdentifiers;
    }
}
