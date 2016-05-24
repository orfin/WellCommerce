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
 * Interface SearchAdapterInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface SearchAdapterInterface
{
    public function addDocument(DocumentInterface $document);

    public function addDocuments(Collection $collection);

    public function removeDocument(DocumentInterface $document);

    public function updateDocument(DocumentInterface $document);

    public function createIndex();

    public function removeIndex();

    public function flushIndex();

    public function optimizeIndex();

    public function getStats();

    public function search(SearchQueryBuilderInterface $builder, string $type) : array;
}
