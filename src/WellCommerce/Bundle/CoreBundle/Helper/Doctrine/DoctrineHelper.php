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

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\Mapping\ClassMetadataFactory;
use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Filter\SQLFilter;
use Doctrine\ORM\Query\FilterCollection;
use Doctrine\ORM\QueryBuilder;

/**
 * Class DoctrineHelper
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
final class DoctrineHelper implements DoctrineHelperInterface
{
    /**
     * @var ManagerRegistry
     */
    private $registry;
    
    /**
     * DoctrineHelper constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }
    
    public function disableFilter(string $filter)
    {
        $this->getDoctrineFilters()->disable($filter);
    }
    
    public function enableFilter(string $filter) : SQLFilter
    {
        return $this->getDoctrineFilters()->enable($filter);
    }
    
    public function getDoctrineFilters() : FilterCollection
    {
        return $this->getEntityManager()->getFilters();
    }
    
    public function getEntityManager() : EntityManagerInterface
    {
        return $this->registry->getManager();
    }
    
    public function getClassMetadata(string $className) : ClassMetadata
    {
        return $this->getEntityManager()->getClassMetadata($className);
    }
    
    public function getClassMetadataForEntity($object) : ClassMetadata
    {
        return $this->getClassMetadata($this->getRealClass($object));
    }
    
    public function getAllMetadata() : array
    {
        return $this->getMetadataFactory()->getAllMetadata();
    }
    
    public function hasClassMetadataForEntity($object) : bool
    {
        return $this->getMetadataFactory()->hasMetadataFor($this->getRealClass($object));
    }
    
    public function getMetadataFactory() : ClassMetadataFactory
    {
        return $this->getEntityManager()->getMetadataFactory();
    }

    public function getAllClassesForQueryBuilder(QueryBuilder $queryBuilder) : array
    {
        $classes      = [];
        $rootEntities = $queryBuilder->getRootEntities();
        foreach ($rootEntities as $rootEntity) {
            $classes[$rootEntity] = $rootEntity;
            $metadata             = $this->getClassMetadata($rootEntity);
            $this->addAssociationsTargetClasses($metadata, $classes);
        }
        
        return $classes;
    }

    public function getRepositoryForClass(string $className) : EntityRepository
    {
        return $this->getEntityManager()->getRepository($className);
    }

    public function truncateTable(string $className)
    {
        $entityManager = $this->getEntityManager();
        $metadata      = $this->getClassMetadata($className);
        if ($metadata instanceof ClassMetadata) {
            $repository = $entityManager->getRepository($className);
            $collection = $repository->findAll();
            
            foreach ($collection as $entity) {
                $entityManager->remove($entity);
            }
            
            $entityManager->flush();
            
            return true;
        }
        
        return false;
    }

    private function addAssociationsTargetClasses(ClassMetadata $metadata, array &$classes)
    {
        $associationNames = $metadata->getAssociationNames();
        foreach ($associationNames as $associationName) {
            $associationClass           = $metadata->getAssociationTargetClass($associationName);
            $classes[$associationClass] = $associationClass;
        }
    }

    private function getRealClass($object) : string
    {
        return ClassUtils::getRealClass(get_class($object));
    }
}
