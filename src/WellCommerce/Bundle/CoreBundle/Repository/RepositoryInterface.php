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

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface RepositoryInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface RepositoryInterface
{
    /**
     * Creates new entity
     *
     * @return \Doctrine\Entity
     */
    public function createNew();

    /**
     * Creates a new QueryBuilder instance that is prepopulated for this entity name.
     *
     * @param string $alias
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createQueryBuilder($alias);

    /**
     * Returns entity alias
     *
     * @return string
     */
    public function getAlias();

    /**
     * Returns entities name
     *
     * @return string
     */
    public function getName();

    /**
     * Resolves request parameters and tries to find corresponding entity
     *
     * @param Request $request
     * @param array   $criteria
     *
     * @return mixed|null|object
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function findResource(Request $request, array $criteria = []);

    /**
     * Returns class metadata
     *
     * @return \Doctrine\ORM\Mapping\ClassMetadata
     */
    public function getMetadata();

    /**
     * Returns collection prepared to use in optioned form fields
     *
     * @param string $labelField
     *
     * @return array
     */
    public function getCollectionToSelect($labelField = 'name');

    /**
     * Returns property accessor
     *
     * @return \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    public function getPropertyAccessor();

} 