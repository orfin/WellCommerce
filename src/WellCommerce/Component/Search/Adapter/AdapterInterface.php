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

namespace WellCommerce\Component\Search\Adapter;

use WellCommerce\Component\Search\Model\DocumentInterface;
use WellCommerce\Component\Search\Request\SearchRequestInterface;

/**
 * Interface AdapterInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface AdapterInterface
{
    public function search(SearchRequestInterface $request) : array;

    public function createIndex(string $locale);

    public function removeIndex(string $locale);

    public function flushIndex(string $locale);

    public function optimizeIndex(string $locale);

    public function addDocument(DocumentInterface $document);

    public function updateDocument(DocumentInterface $document);

    public function removeDocument(DocumentInterface $document);
}
