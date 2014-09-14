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
     * Constructor
     *
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Transforms entity collection to array containing only primary keys
     *
     * @param $collection
     *
     * @return array
     */
    public function transform($collection)
    {
        $meta       = $this->repository->getMetadata();
        $identifier = $meta->getSingleIdentifierFieldName();
        $accessor   = $this->repository->getPropertyAccessor();
        $items      = [];
        foreach ($collection as $item) {
            $items[] = $accessor->getValue($item, $identifier);
        }

        return $items;
    }

    /**
     * Transforms passed identifiers to collection of entities
     *
     * @param $ids
     *
     * @return ArrayCollection
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