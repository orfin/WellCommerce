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

use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductTranslation;
use WellCommerce\Component\SearchEngine\Document\DocumentInterface;
use WellCommerce\Component\SearchEngine\Document\Field\DocumentFieldCollection;
use WellCommerce\Component\SearchEngine\Document\Field\TextField;

/**
 * Class ProductDocument
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ProductDocument implements DocumentInterface
{
    /**
     * @var ProductInterface
     */
    private $product;
    
    /**
     * ProductDocument constructor.
     *
     * @param ProductInterface $product
     */
    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }
    
    public function getIdentifier() : int
    {
        return $this->product->getId();
    }
    
    public function getFields() : DocumentFieldCollection
    {
        $collection = new DocumentFieldCollection();
        
        $collection->add(new TextField('sku', $this->product->getSku()));
        
        $this->product->getTranslations()->map(function (ProductTranslation $translation) use ($collection) {
            $collection->add(new TextField('name_' . $translation->getLocale(), $translation->getName()));
            $collection->add(new TextField('description_' . $translation->getLocale(), $translation->getDescription()));
            $collection->add(new TextField('short_description_' . $translation->getLocale(), $translation->getShortDescription()));
        });
        
        return $collection;
    }
    
    public function getType()
    {
        return 'product';
    }
}
