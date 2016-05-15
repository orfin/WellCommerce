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

use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;

/**
 * Class ElasticSearchIndexer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ElasticSearchIndexer implements IndexerInterface
{
    public function index(EntityInterface $entity)
    {
        // TODO: Implement index() method.
    }

    public function deindex(EntityInterface $entity)
    {
        // TODO: Implement deindex() method.
    }
}
