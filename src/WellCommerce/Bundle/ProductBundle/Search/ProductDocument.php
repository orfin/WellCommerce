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

use Doctrine\Common\Collections\Collection;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Component\Search\Model\DocumentInterface;
use WellCommerce\Component\Search\Model\FieldInterface;
use WellCommerce\Component\Search\Model\TypeInterface;

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
     * @var TypeInterface
     */
    private $type;
    
    /**
     * @var string
     */
    private $locale;
    
    /**
     * ProductDocument constructor.
     *
     * @param ProductInterface $product
     * @param TypeInterface    $type
     * @param string           $locale
     */
    public function __construct(ProductInterface $product, TypeInterface $type, string $locale)
    {
        $this->product = $product;
        $this->type    = $type;
        $this->locale  = $locale;
    }
    
    public function getIdentifier() : int
    {
        return $this->product->getId();
    }
    
    public function getEntity() : EntityInterface
    {
        return $this->product;
    }

    public function getType() : TypeInterface
    {
        return $this->type;
    }

    public function getLocale() : string
    {
        return $this->locale;
    }
    
    public function getFields() : Collection
    {
        $language = new ExpressionLanguage();
        $fields   = $this->type->getFields();
        
        $fields->map(function (FieldInterface $field) use ($language) {
            $value = $this->getFieldValue($field->getValueExpression(), $language);
            $field->setValue($value);
        });
        
        return $fields;
    }
    
    private function getFieldValue(string $expression, ExpressionLanguage $language) : string
    {
        $value = $language->evaluate($expression, [
            'resource' => $this->product,
            'locale'   => $this->locale
        ]);
        
        return $value ?? '';
    }
}
