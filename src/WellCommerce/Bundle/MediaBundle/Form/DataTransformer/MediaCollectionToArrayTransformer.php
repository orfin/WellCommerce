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
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\DataTransformerInterface;
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;

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
     * {@inheritdoc}
     */
    public function transform($collection, ElementInterface $element)
    {
        if (null === $collection) {
            return $collection;
        }

        $items = [];
        foreach ($collection as $item) {
            if ($item->getMainPhoto() == 1) {
                $items['main_photo'] = $item->getPhoto()->getId();
            }
            $items['photos'][] = $item->getPhoto()->getId();
        }

        return $items;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform(ElementInterface $element, $entity)
    {
        $collection = new ArrayCollection();
        $values     = $element->getValue();

        foreach ($values as $key => $id) {
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