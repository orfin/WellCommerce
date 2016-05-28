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

use WellCommerce\Bundle\SearchBundle\Document;
use WellCommerce\Bundle\SearchBundle\Document\DocumentInterface;
use WellCommerce\Bundle\SearchBundle\Type\IndexType;

/**
 * Class ZendLuceneAdapter
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ZendLuceneAdapter implements AdapterInterface
{
    public function getIndexName(string $locale) : string
    {
        // TODO: Implement getIndexName() method.
    }

    public function createIndex(string $locale)
    {
        // TODO: Implement createIndex() method.
    }

    public function removeIndex(string $locale)
    {
        // TODO: Implement removeIndex() method.
    }

    public function flushIndex(string $locale)
    {
        // TODO: Implement flushIndex() method.
    }

    public function optimizeIndex(string $locale)
    {
        // TODO: Implement optimizeIndex() method.
    }

    public function addDocument(DocumentInterface $document)
    {
        // TODO: Implement addDocument() method.
    }

    public function updateDocument(DocumentInterface $document)
    {
        // TODO: Implement updateDocument() method.
    }

    public function removeDocument(DocumentInterface $document)
    {
        // TODO: Implement removeDocument() method.
    }
}
