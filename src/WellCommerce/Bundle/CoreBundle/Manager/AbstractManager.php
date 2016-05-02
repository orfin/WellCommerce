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

use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\EntityFactoryInterface;
use WellCommerce\Bundle\DoctrineBundle\Repository\RepositoryInterface;

/**
 * Class AbstractManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractManager extends AbstractContainerAware implements ManagerInterface
{
    /**
     * @var RepositoryInterface
     */
    protected $repository;
    
    /**
     * @var EntityFactoryInterface
     */
    protected $factory;
    
    /**
     * AbstractManager constructor.
     *
     * @param RepositoryInterface    $repository
     * @param EntityFactoryInterface $factory
     */
    public function __construct(RepositoryInterface $repository, EntityFactoryInterface $factory)
    {
        $this->repository = $repository;
        $this->factory    = $factory;
    }
    
    public function getRepository() : RepositoryInterface
    {
        return $this->repository;
    }
    
    public function getFactory() : EntityFactoryInterface
    {
        return $this->factory;
    }
    
    public function initResource() : EntityInterface
    {
        return $this->factory->create();
    }
    
    public function createResource(EntityInterface $resource)
    {
        $em = $this->getEntityManager();
        $em->persist($resource);
        $em->flush();
    }
    
    public function updateResource(EntityInterface $resource)
    {
        $this->getEntityManager()->flush();
    }
    
    public function removeResource(EntityInterface $resource)
    {
        $em = $this->getEntityManager();
        $em->remove($resource);
        $em->flush();
    }
}
