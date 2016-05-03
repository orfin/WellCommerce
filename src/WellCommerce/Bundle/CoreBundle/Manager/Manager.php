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
 * Class Manager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Manager implements ManagerInterface
{
    /**
     * @var RepositoryInterface
     */
    private $repository;
    
    /**
     * @var EntityFactoryInterface
     */
    private $factory;
    
    /**
     * @var DoctrineHelperInterface
     */
    private $helper;
    
    /**
     * Manager constructor.
     *
     * @param EntityFactoryInterface   $factory
     * @param RepositoryInterface|null $repository
     * @param DoctrineHelperInterface  $helper
     */
    public function __construct(EntityFactoryInterface $factory, RepositoryInterface $repository = null, DoctrineHelperInterface $helper)
    {
        $this->factory    = $factory;
        $this->repository = $repository;
        $this->helper     = $helper;
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
    
    public function getDoctrineHelper() : DoctrineHelperInterface
    {
        return $this->helper;
    }
    
    public function getEntityManager() : ObjectManager
    {
        return $this->helper->getEntityManager();
    }
}
