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

namespace WellCommerce\Bundle\CoreBundle\Repository;

use WellCommerce\Bundle\DataSetBundle\Repository\DataSetAwareRepositoryInterface;

/**
 * Interface RepositoryInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface RepositoryInterface extends DataSetAwareRepositoryInterface
{
    /**
     * Creates a new QueryBuilder instance that is prepopulated for this entity name.
     *
     * @param string $alias
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createQueryBuilder($alias);

    /**
     * Returns a resource for given primary key
     *
     * @param $id
     *
     * @return mixed
     */
    public function find($id);

    /**
     * Returns all entities
     *
     * @return mixed
     */
    public function findAll();

    /**
     * Returns single entity using additional criteria
     *
     * @param array $criteria
     * @param array $orderBy
     *
     * @return mixed
     */
    public function findOneBy(array $criteria, array $orderBy = null);

    /**
     * Returns all entities using additional criteria
     *
     * @param array $criteria
     *
     * @return mixed
     */
    public function findBy(array $criteria);

    /**
     * @return \Doctrine\ORM\Mapping\ClassMetadata
     */
    public function getMetaData();
}
