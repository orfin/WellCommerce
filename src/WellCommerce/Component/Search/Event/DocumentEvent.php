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

namespace WellCommerce\Component\Search\Event;

use Symfony\Component\EventDispatcher\Event;
use WellCommerce\Component\Search\Model\DocumentInterface;

/**
 * Class DocumentEvent
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class DocumentEvent extends Event
{
    const PRE_INDEX_EVENT  = 'search_document.pre_index';
    const PRE_UPDATE_EVENT = 'search_document.pre_update';

    /**
     * @var DocumentInterface
     */
    private $document;

    /**
     * DocumentEvent constructor.
     *
     * @param DocumentInterface $document
     */
    public function __construct(DocumentInterface $document)
    {
        $this->document = $document;
    }

    public function getDocument() : DocumentInterface
    {
        return $this->document;
    }
}
