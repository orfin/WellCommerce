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

namespace WellCommerce\Component\SearchEngine\Adapter;

use WellCommerce\Component\SearchEngine\Document\DocumentInterface;

/**
 * Class ZendLuceneAdapter
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ZendLuceneAdapter implements AdapterInterface
{
    public function addDocument(DocumentInterface $document)
    {
    }

    public function removeDocument(DocumentInterface $document)
    {
    }

    public function updateDocument(DocumentInterface $document)
    {
    }
}
