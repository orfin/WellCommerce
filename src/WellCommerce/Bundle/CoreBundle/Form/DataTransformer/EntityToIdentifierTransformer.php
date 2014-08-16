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
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function reverseTransform($id)
    {
        $item = $this->repository->find($id);

        return $item;
    }
} 