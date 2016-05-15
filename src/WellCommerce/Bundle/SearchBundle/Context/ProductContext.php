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

namespace WellCommerce\Bundle\SearchBundle\Context;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\PropertyAccess\PropertyAccess;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\SearchBundle\Model\SearchField;

/**
 * Class ProductContext
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ProductContext implements DocumentContextInterface
{
    /**
     * @var ProductInterface
     */
    private $product;
    
    /**
     * ProductContext constructor.
     *
     * @param ProductInterface $product
     */
    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }
    
    public function getFieldsCollection() : Collection
    {
        $accessor     = PropertyAccess::createPropertyAccessor();
        $fields       = new ArrayCollection();
        $translations = $this->product->getTranslations();

        foreach ($translations as $locale => $translation) {
            $fields->add(new SearchField(
                'name_' . $locale,
                $accessor->getValue($translation, 'name')
            ));

            $fields->add(new SearchField(
                'description_' . $locale,
                $accessor->getValue($translation, 'description')
            ));

            $fields->add(new SearchField(
                'short_description' . $locale,
                $accessor->getValue($translation, 'shortDescription')
            ));
        }

        $fields->add(new SearchField('sku', $this->product->getSku()));

        return $fields;
    }
}
