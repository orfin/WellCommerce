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
     * Tries to find a resource using request parameters
     *
     * @param Request $request
     * @param array   $criteria
     *
     * @return mixed
     */
    public function findResource(Request $request, array $criteria = []);

    /**
     * Returns class metadata
     *
     * @return \Doctrine\ORM\Mapping\ClassMetadata
     */
    public function getMetadata();

} 