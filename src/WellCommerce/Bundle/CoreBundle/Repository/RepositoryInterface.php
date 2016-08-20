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

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder;
use WellCommerce\Component\DataSet\Repository\DataSetAwareRepositoryInterface;

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
     * @return QueryBuilder
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
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     *
     * @return mixed
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);

    /**
     * Creates QueryBuilder instance
     *
     * @return QueryBuilder
     */
    public function getQueryBuilder() : QueryBuilder;

    /**
     * @return ClassMetadata
     */
    public function getMetaData() : ClassMetadata;

    /**
     * Select all elements from a selectable that match the expression and
     * return a new collection containing these elements.
     *
     * @param Criteria $criteria
     *
     * @return Collection
     */
    public function matching(Criteria $criteria);

    /**
     * Returns the total count of entities in repository
     *
     * @return int
     */
    public function getTotalCount() : int;
}
