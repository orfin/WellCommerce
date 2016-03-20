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

namespace WellCommerce\Bundle\DoctrineBundle\Helper\Doctrine;

use Doctrine\ORM\QueryBuilder;

/**
 * Interface DoctrineHelperInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface DoctrineHelperInterface
{
    /**
     * Gets the enabled filters.
     *
     * @return \Doctrine\ORM\Query\FilterCollection The active filter collection.
     */
    public function getDoctrineFilters();

    /**
     * Returns Doctrine manager
     *
     * @return \Doctrine\Common\Persistence\ObjectManager|object
     */
    public function getEntityManager();

    /**
     * Disables Doctrine filter
     *
     * @param string $filter Filter name
     */
    public function disableFilter($filter);

    /**
     * Enables Doctrine filter
     *
     * @param string $filter
     *
     * @return \Doctrine\ORM\Query\Filter\SQLFilter
     */
    public function enableFilter($filter);

    /**
     * Returns class metadata for given class name
     *
     * @param string $className
     *
     * @return \Doctrine\Common\Persistence\Mapping\ClassMetadata
     */
    public function getClassMetadata($className);

    /**
     * Returns class metadata for given object
     *
     * @param object $entity
     *
     * @return \Doctrine\Common\Persistence\Mapping\ClassMetadata
     */
    public function getClassMetadataForEntity($entity);

    /**
     * Returns true if entity is managed through Doctrine, false otherwise
     *
     * @param object $object
     *
     * @return bool
     */
    public function hasClassMetadataForEntity($object);

    /**
     * @return \Doctrine\Common\Persistence\Mapping\ClassMetadata[]
     */
    public function getAllMetadata();

    /**
     * Truncates table
     *
     * @param string $className
     */
    public function truncateTable($className);

    /**
     * @return \Doctrine\Common\Persistence\Mapping\ClassMetadataFactory
     */
    public function getMetadataFactory();

    /**
     * Returns the root and association classes used in given QueryBuilder
     *
     * @param QueryBuilder $queryBuilder
     *
     * @return array
     */
    public function getAllClassesForQueryBuilder(QueryBuilder $queryBuilder) : array;
}
