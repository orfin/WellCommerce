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

use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;

/**
 * Class MediaEntityToIdentifierTransformer
 *
 * @package WellCommerce\Bundle\MediaBundle\Form\DataTransformer
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MediaEntityToIdentifierTransformer
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
     * Transforms entity to primary key identifier
     *
     * @param $entity
     *
     * @return int|mixed
     */
    public function transform($entity)
    {
        if (null == $entity) {
            return 0;
        }
        $meta       = $this->repository->getMetadata();
        $identifier = $meta->getSingleIdentifierFieldName();
        $accessor   = $this->repository->getPropertyAccessor();

        return $accessor->getValue($entity, $identifier);
    }

    /**
     * Transforms identifier to entity
     *
     * @param $id
     *
     * @return mixed
     */
    public function reverseTransform($data)
    {
        $item = null;
        if (isset($data[0])) {
            $id   = $data[0];
            $item = $this->repository->find($id);
        }

        return $item;
    }
} 