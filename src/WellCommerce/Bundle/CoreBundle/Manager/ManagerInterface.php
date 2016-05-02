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

namespace WellCommerce\Bundle\CoreBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\EntityFactoryInterface;
use WellCommerce\Bundle\DoctrineBundle\Helper\Doctrine\DoctrineHelperInterface;
use WellCommerce\Bundle\DoctrineBundle\Repository\RepositoryInterface;

/**
 * Interface ManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ManagerInterface
{
    /**
     * Returns the helper for Doctrine calls
     *
     * @return DoctrineHelperInterface
     */
    public function getDoctrineHelper() : DoctrineHelperInterface;
    
    /**
     * Returns the Doctrine manager
     *
     * @return ObjectManager
     */
    public function getEntityManager() : ObjectManager;
    
    /**
     * Returns the repository
     *
     * @return RepositoryInterface
     */
    public function getRepository() : RepositoryInterface;
    
    /**
     * Returns the factory
     *
     * @return EntityFactoryInterface
     */
    public function getFactory() : EntityFactoryInterface;
    
    /**
     * Initializes new resource object
     *
     * @return EntityInterface
     */
    public function initResource() : EntityInterface;
    
    /**
     * Persists new resource
     *
     * @param EntityInterface $resource
     */
    public function createResource(EntityInterface $resource);
    
    /**
     * Updates existing resource
     *
     * @param EntityInterface $resource
     */
    public function updateResource(EntityInterface $resource);
    
    /**
     * Removes a resource
     *
     * @param EntityInterface $resource
     */
    public function removeResource(EntityInterface $resource);
}
