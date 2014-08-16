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
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;

/**
 * Class CollectionToArrayTransformer
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\DataTransformer
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CollectionToArrayTransformer
{
    /**
     * @var \WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface
     */
    private $repository;

    /**
     * Constructor
     *
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($collection)
    {
        $meta       = $this->repository->getMetadata();
        $identifier = $meta->getSingleIdentifierFieldName();
        $accessor   = PropertyAccess::createPropertyAccessor();
        $items      = [];
        foreach ($collection as $item) {
            $items[] = $accessor->getValue($item, $identifier);
        }

        return $items;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($ids)
    {
        $collection = new ArrayCollection();
        if (null == $ids) {
            return $collection;
        }
        foreach ($ids as $id) {
            $item = $this->repository->find($id);
            $collection->add($item);
        }

        return $collection;
    }

} 