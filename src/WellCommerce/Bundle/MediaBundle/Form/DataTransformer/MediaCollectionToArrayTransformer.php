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

namespace WellCommerce\Bundle\MediaBundle\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\DataTransformerInterface;

/**
 * Class CollectionToArrayTransformer
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\DataTransformer
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MediaCollectionToArrayTransformer implements DataTransformerInterface
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
     * Transforms entity collection to array containing only primary keys
     *
     * @param $collection
     *
     * @return array
     */
    public function transform($collection)
    {
        if (null == $collection) {
            return null;
        }
        $items = [];
        foreach ($collection as $item) {
            if($item->getMainPhoto() == 1){
                $items['main_photo'] = $item->getPhoto()->getId();
            }
            $items['photos'][] = $item->getPhoto()->getId();
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
    public function reverseTransform($data)
    {
        $collection = new ArrayCollection();

        foreach ($data as $key => $id) {
            if (is_int($key)) {
                $photo = $this->repository->find($id);
                $collection->add($photo);
            }
        }

        return [
            'data'       => $data,
            'collection' => $collection
        ];
    }
}