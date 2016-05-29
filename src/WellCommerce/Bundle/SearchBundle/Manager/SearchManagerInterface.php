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

use WellCommerce\Component\Search\Model\DocumentInterface;
use WellCommerce\Component\Search\Model\SearchRequestInterface;
use WellCommerce\Component\Search\Model\TypeInterface;

/**
 * Interface SearchManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface SearchManagerInterface
{
    public function search(SearchRequestInterface $request) : array;

    public function addDocument(DocumentInterface $document);

    public function updateDocument(DocumentInterface $document);

    public function removeDocument(DocumentInterface $document);

    public function flushIndex(string $locale);

    public function optimizeIndex(string $locale);

    public function removeIndex(string $locale);

    public function getType(string $type) : TypeInterface;
}
