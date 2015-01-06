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

namespace WellCommerce\Bundle\CoreBundle\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\PropertyAccess\PropertyAccess;
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;

/**
 * Class CollectionToArrayTransformer
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\DataTransformer
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CollectionToArrayTransformer implements DataTransformerInterface
{
    /**
     * @var \WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface
     */
    protected $repository;

    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected $propertyAccessor;

    /**
     * Constructor
     *
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository       = $repository;
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * {@inheritdoc}
     */
    public function transform($collection, ElementInterface $element)
    {
        $identifier = $element->getPropertyPath();
        $items      = [];

        foreach ($collection as $item) {
            $items[] = $this->propertyAccessor->getValue($item, $identifier);
        }

        return $items;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform(ElementInterface $element, $entity)
    {
        $propertyPath = $element->getPropertyPath();
        $collection   = new ArrayCollection();
        $values       = $element->getValue();

        if (empty($values)) {
            return $collection;
        }

        foreach ($values as $value) {
            $item = $this->repository->find($value);
            $collection->add($item);
        }

        $this->propertyAccessor->setValue($entity, $propertyPath, $collection);
    }
}