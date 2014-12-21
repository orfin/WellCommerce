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

namespace WellCommerce\Bundle\AttributeBundle\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\CollectionToArrayTransformer;

/**
 * Class AttributeCollectionToArrayTransformer
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeCollectionToArrayTransformer extends CollectionToArrayTransformer
{
    /**
     * @var \WellCommerce\Bundle\AttributeBundle\Repository\AttributeRepositoryInterface
     */
    protected $repository;

    /**
     * Transforms passed identifiers to collection of entities
     *
     * @param $ids
     *
     * @return ArrayCollection
     */
    public function reverseTransform($data)
    {
        $collection = new ArrayCollection();
        if (null == $data || empty($data)) {
            return $collection;
        }
        foreach ($data['editor'] as $attribute) {
            $item = $this->repository->findOrCreate($attribute);
            $collection->add($item);
        }

        return $collection;
    }
}