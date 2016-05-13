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

namespace WellCommerce\Bundle\SearchBundle\Indexer;

use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\ProductBundle\Repository\ProductRepositoryInterface;
use WellCommerce\Bundle\SearchBundle\Manager\SearchIndexManagerInterface;
use ZendSearch\Lucene\Document;
use ZendSearch\Lucene\Document\Field;

/**
 * Class LuceneProductIndexer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class LuceneProductIndexer implements IndexerInterface
{

    public function __construct(string $indexName)
    {
    }

    public function create()
    {
        // TODO: Implement create() method.
    }

    public function get()
    {
        // TODO: Implement get() method.
    }

    public function remove()
    {
        // TODO: Implement remove() method.
    }

    public function erase()
    {
        // TODO: Implement erase() method.
    }

    public function reindex()
    {
        // TODO: Implement reindex() method.
    }

}
