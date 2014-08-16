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

use Symfony\Component\PropertyAccess\PropertyAccess;
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;

/**
 * Class EntityToIdentifierTransformer
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\DataTransformer
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class EntityToIdentifierTransformer
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
        $accessor   = PropertyAccess::createPropertyAccessor();

        return $accessor->getValue($entity, $identifier);;
    }

    /**
     * Transforms identifier to entity
     *
     * @param $id
     *
     * @return mixed
     */
    public function reverseTransform($id)
    {
        $item = $this->repository->find($id);

        return $item;
    }
} 