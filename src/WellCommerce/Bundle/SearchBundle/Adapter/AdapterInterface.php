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

use WellCommerce\Bundle\SearchBundle\Document\DocumentInterface;

/**
 * Interface AdapterInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface AdapterInterface
{
    public function getIndexName(string $locale) : string;

    public function createIndex(string $locale);

    public function removeIndex(string $locale);

    public function flushIndex(string $locale);

    public function optimizeIndex(string $locale);

    public function addDocument(DocumentInterface $document);

    public function updateDocument(DocumentInterface $document);

    public function removeDocument(DocumentInterface $document);
}
