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

namespace WellCommerce\Bundle\OrderBundle\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\PropertyAccess\PropertyPathInterface;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\CollectionToArrayTransformer;
use WellCommerce\Bundle\CoreBundle\Helper\Image\ImageHelperInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderProductInterface;
use WellCommerce\Bundle\OrderBundle\Manager\OrderProductManagerInterface;

/**
 * Class OrderProductCollectionToArrayTransformer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderProductCollectionToArrayTransformer extends CollectionToArrayTransformer
{
    /**
     * @var OrderProductManagerInterface
     */
    private $manager;
    
    /**
     * @var ImageHelperInterface
     */
    private $imageHelper;
    
    public function setOrderProductManager(OrderProductManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    
    public function setImageHelper(ImageHelperInterface $imageHelper)
    {
        $this->imageHelper = $imageHelper;
    }
    
    /**
     * {@inheritdoc}
     */
    public function transform($modelData)
    {
        $values = [];
        
        if ($modelData instanceof Collection) {
            $modelData->map(function (OrderProductInterface $orderProduct) use (&$values) {
                
                $variantId = $orderProduct->hasVariant() ? $orderProduct->getVariant()->getId() : 0;
                $photoPath = $orderProduct->getProduct()->getPhoto()->getPath();
                $symbol    = $orderProduct->hasVariant() ? $orderProduct->getVariant()->getSymbol() : $orderProduct->getProduct()->getSku();
                
                $values[] = [
                    'id'               => $orderProduct->getId(),
                    'product_id'       => $orderProduct->getProduct()->getId(),
                    'product_name'     => $orderProduct->getProduct()->translate()->getName(),
                    'gross_amount'     => $orderProduct->getSellPrice()->getGrossAmount(),
                    'quantity'         => $orderProduct->getQuantity(),
                    'ean'              => $symbol,
                    'previousquantity' => $orderProduct->getQuantity(),
                    'trackstock'       => $orderProduct->getProduct()->getTrackStock(),
                    'tax_rate'         => $orderProduct->getSellPrice()->getTaxRate(),
                    'tax_value'        => $orderProduct->getSellPrice()->getTaxAmount(),
                    'previousvariant'  => $variantId,
                    'variant'          => $variantId,
                    'variant_options'  => $this->getVariantOptions($orderProduct),
                    'weight'           => $orderProduct->getWeight(),
                    'stock'            => $orderProduct->getProduct()->getStock(),
                    'thumb'            => null !== $photoPath ? $this->imageHelper->getImage($photoPath, 'medium') : '',
                ];
            });
        }
        
        return $values;
    }
    
    protected function getVariantOptions(OrderProductInterface $orderProduct)
    {
        if ($orderProduct->hasVariant()) {
            $options = [];
            foreach ($orderProduct->getOptions() as $name => $option) {
                $options[] = $option;
            }
            
            return implode(', ', $options);
        }
        
        return '';
    }
    
    /**
     * {@inheritdoc}
     */
    public function reverseTransform($modelData, PropertyPathInterface $propertyPath, $values)
    {
        $collection = new ArrayCollection();
        if ($modelData instanceof OrderInterface) {
            foreach ($values as $product) {
                $orderProduct = $this->manager->addUpdateOrderProduct($product, $modelData);
                $collection->add($orderProduct);
            }
        
            $modelData->setProducts($collection);
        }
    }
}
