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

namespace WellCommerce\Bundle\CoreBundle\Helper\Doctrine;

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
     * Returns class metadata if exists
     *
     * @param $className
     *
     * @return \Doctrine\Common\Persistence\Mapping\ClassMetadata
     */
    public function getClassMetadata($className);
} 