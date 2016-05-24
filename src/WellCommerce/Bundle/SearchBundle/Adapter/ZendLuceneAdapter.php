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

namespace WellCommerce\Bundle\SearchBundle\Adapter;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\SearchBundle\Builder\SearchQueryBuilderInterface;
use WellCommerce\Bundle\SearchBundle\Document\DocumentInterface;

/**
 * Class ZendLuceneAdapter
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ZendLuceneAdapter implements SearchAdapterInterface
{
    public function addDocument(DocumentInterface $document)
    {
        // TODO: Implement addDocument() method.
    }

    public function addDocuments(Collection $collection)
    {
        // TODO: Implement addDocuments() method.
    }

    public function removeDocument(DocumentInterface $document)
    {
        // TODO: Implement removeDocument() method.
    }

    public function updateDocument(DocumentInterface $document)
    {
        // TODO: Implement updateDocument() method.
    }

    public function createIndex()
    {
        // TODO: Implement createIndex() method.
    }

    public function removeIndex()
    {
        // TODO: Implement removeIndex() method.
    }

    public function flushIndex()
    {
        // TODO: Implement flushIndex() method.
    }

    public function optimizeIndex()
    {
        // TODO: Implement optimizeIndex() method.
    }

    public function getStats()
    {
        // TODO: Implement getStats() method.
    }

    public function search(SearchQueryBuilderInterface $builder, string $type) : array
    {
        // TODO: Implement search() method.
    }
}
