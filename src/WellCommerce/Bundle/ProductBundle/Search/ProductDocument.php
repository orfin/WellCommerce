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

namespace WellCommerce\Bundle\ProductBundle\Search;

use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\SearchBundle\Document\DocumentField;
use WellCommerce\Bundle\SearchBundle\Document\DocumentFieldCollection;
use WellCommerce\Bundle\SearchBundle\Document\DocumentInterface;
use WellCommerce\Bundle\SearchBundle\Type\IndexTypeInterface;

/**
 * Class ProductDocument
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductDocument implements DocumentInterface
{
    /**
     * @var ProductInterface
     */
    private $product;
    
    /**
     * @var string
     */
    private $locale;
    
    /**
     * ProductDocument constructor.
     *
     * @param ProductInterface $product
     * @param string           $locale
     */
    public function __construct(ProductInterface $product, string $locale)
    {
        $this->product = $product;
        $this->locale  = $locale;
    }
    
    public function getIdentifier() : int
    {
        return $this->product->getId();
    }
    
    public function getIndexType() : IndexTypeInterface
    {
        // TODO: Implement getIndexType() method.
    }
    
    public function getLocale() : string
    {
        return $this->locale;
    }
    
    public function getFields() : DocumentFieldCollection
    {
        $collection  = new DocumentFieldCollection();
        $translation = $this->product->translate($this->locale);
        $producer    = $this->product->getProducer()->translate($this->locale)->getName();
        
        $collection->add(new DocumentField([
            'name' => 'sku',    
            'value' => 'sku',    
            'indexable' => 'sku',    
        ]));
        
        $collection->add(new DocumentField('sku', $this->product->getSku(), true, 1));
        $collection->add(new DocumentField('name', $translation->getName(), true, 1));
        $collection->add(new DocumentField('description', $translation->getDescription(), true, 0.5));
        $collection->add(new DocumentField('short_description', $translation->getShortDescription(), true, 0.5));
        $collection->add(new DocumentField('producer', $producer, true, 0.5));
    }
}
