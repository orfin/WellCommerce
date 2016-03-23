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

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\QueryBuilder;

/**
 * Class DoctrineHelper
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class DoctrineHelper implements DoctrineHelperInterface
{
    /**
     * @var ManagerRegistry
     */
    protected $registry;
    
    /**
     * Constructor
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }
    
    /**
     * {@inheritdoc}
     */
    public function disableFilter($filter)
    {
        $this->getDoctrineFilters()->disable($filter);
    }
    
    /**
     * {@inheritdoc}
     */
    public function enableFilter($filter)
    {
        return $this->getDoctrineFilters()->enable($filter);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getDoctrineFilters()
    {
        return $this->getEntityManager()->getFilters();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getEntityManager()
    {
        return $this->registry->getManager();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getClassMetadata($className)
    {
        return $this->getEntityManager()->getClassMetadata($className);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getClassMetadataForEntity($object)
    {
        $className = ClassUtils::getRealClass(get_class($object));
        
        return $this->getClassMetadata($className);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAllMetadata()
    {
        return $this->getMetadataFactory()->getAllMetadata();
    }
    
    /**
     * {@inheritdoc}
     */
    public function hasClassMetadataForEntity($object)
    {
        $className = ClassUtils::getRealClass(get_class($object));
        
        return $this->getMetadataFactory()->hasMetadataFor($className);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getMetadataFactory()
    {
        return $this->getEntityManager()->getMetadataFactory();
    }

    /**
     * {@inheritdoc}
     */
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
    
    protected function addAssociationsTargetClasses(ClassMetadata $metadata, array &$classes)
    {
        $associationNames = $metadata->getAssociationNames();
        foreach ($associationNames as $associationName) {
            $associationClass           = $metadata->getAssociationTargetClass($associationName);
            $classes[$associationClass] = $associationClass;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function truncateTable($className)
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
}
