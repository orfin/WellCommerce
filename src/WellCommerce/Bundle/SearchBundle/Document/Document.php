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

namespace WellCommerce\Bundle\SearchBundle\Document;

use WellCommerce\Bundle\SearchBundle\Type\IndexTypeInterface;

/**
 * Class Document
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class Document implements DocumentInterface
{
    /**
     * @var int
     */
    private $identifier;
    
    /**
     * @var IndexTypeInterface
     */
    private $indexType;
    
    /**
     * @var IndexTypeInterface
     */
    private $locale;
    
    /**
     * @var DocumentFieldCollection
     */
    private $fields;
    
    /**
     * Document constructor.
     *
     * @param int    $identifier
     * @param string $locale
     */
    public function __construct(int $identifier, string $locale)
    {
        $this->identifier = $identifier;
        $this->locale     = $locale;
        $this->fields     = new DocumentFieldCollection();
    }

    public function getIdentifier() : int
    {
        return $this->identifier;
    }
    
    public function getIndexType() : IndexTypeInterface
    {
        return $this->indexType;
    }
    
    public function getLocale() : string
    {
        return $this->locale;
    }

    public function addField(DocumentFieldInterface $field)
    {
        $this->fields->set($field->getName(), $field);

        return $this;
    }

    public function getFields() : DocumentFieldCollection
    {
        return $this->fields;
    }
}
