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

namespace WellCommerce\Bundle\ProductBundle\Form\DataTransformer;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\PropertyAccess\PropertyPathInterface;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\CollectionToArrayTransformer;
use WellCommerce\Bundle\CoreBundle\Manager\ManagerInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductDistinctionInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\ProductStatusBundle\Entity\ProductStatusInterface;

/**
 * Class ProductDistinctionCollectionToArrayTransformer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ProductDistinctionCollectionToArrayTransformer extends CollectionToArrayTransformer
{
    /**
     * @var ManagerInterface
     */
    private $manager;

    /**
     * @var string
     */
    private $dateFormat = 'm/d/Y';

    public function setProductDistinctionManager(ManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    
    public function transform($modelData)
    {
        $values = [];
        if ($modelData instanceof Collection) {
            $modelData->map(function (ProductDistinctionInterface $distinction) use (&$values) {
                $values[$distinction->getStatus()->getId()] = [
                    'valid_from' => $this->transformDate($distinction->getValidFrom()),
                    'valid_to'   => $this->transformDate($distinction->getValidTo()),
                ];
            });
        }

        return $values;
    }
    
    public function reverseTransform($modelData, PropertyPathInterface $propertyPath, $values)
    {
        if ($modelData instanceof ProductInterface) {
            $collection = new ArrayCollection();
            foreach ($values as $productStatusId => $distinctionValue) {
                if (1 === (int)$distinctionValue['enabled']) {
                    $status      = $this->getRepository()->find($productStatusId);
                    $distinction = $this->getProductDistinction($modelData, $status);
                    $distinction->setValidFrom($this->createDateFromString($distinctionValue['valid_from']));
                    $distinction->setValidTo($this->createDateFromString($distinctionValue['valid_to']));
                    $collection->add($distinction);
                }
            }

            $modelData->setDistinctions($collection);
        }
    }

    private function getProductDistinction(ProductInterface $product, ProductStatusInterface $status) : ProductDistinctionInterface
    {
        $distinction = $this->manager->getRepository()->findOneBy([
            'product' => $product,
            'status'  => $status
        ]);

        if (!$distinction instanceof ProductDistinctionInterface) {
            /** @var ProductDistinctionInterface $distinction */
            $distinction = $this->manager->initResource();
            $distinction->setProduct($product);
            $distinction->setStatus($status);
        }

        return $distinction;
    }

    private function transformDate($date) : string
    {
        if ($date instanceof DateTime) {
            return $date->format($this->dateFormat);
        }

        return '';
    }

    private function createDateFromString($value)
    {
        if (false === $date = DateTime::createFromFormat($this->dateFormat, $value)) {
            $date = null;
        }

        return $date;
    }
}
