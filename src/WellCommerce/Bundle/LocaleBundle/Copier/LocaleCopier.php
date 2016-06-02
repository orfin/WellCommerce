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

namespace WellCommerce\Bundle\LocaleBundle\Copier;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\PropertyAccess\PropertyAccess;
use WellCommerce\Bundle\DoctrineBundle\Helper\Doctrine\DoctrineHelperInterface;
use WellCommerce\Bundle\LocaleBundle\Entity\LocaleAwareInterface;
use WellCommerce\Bundle\LocaleBundle\Entity\LocaleInterface;

/**
 * Class LocaleCopier
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class LocaleCopier implements LocaleCopierInterface
{
    /**
     * @var array
     */
    private $entityClasses;
    
    /**
     * @var DoctrineHelperInterface
     */
    protected $doctrineHelper;
    
    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected $propertyAccessor;
    
    /**
     * LocaleCopier constructor.
     *
     * @param array                   $entityClasses
     * @param DoctrineHelperInterface $doctrineHelper
     */
    public function __construct(array $entityClasses, DoctrineHelperInterface $doctrineHelper)
    {
        $this->entityClasses    = $entityClasses;
        $this->doctrineHelper   = $doctrineHelper;
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
    }
    
    public function copyLocaleData(LocaleInterface $sourceLocale, LocaleInterface $targetLocale)
    {
        $criteria = new Criteria();
        $criteria->where($criteria->expr()->eq('locale', $sourceLocale->getCode()));
        
        foreach ($this->entityClasses as $className => $options) {
            $repository = $this->doctrineHelper->getRepositoryForClass($className);
            $entities   = $repository->matching($criteria);
            $this->duplicateTranslatableEntities($entities, $options['properties'], $targetLocale);
        }

        $this->doctrineHelper->getEntityManager()->flush();
    }
    
    private function duplicateTranslatableEntities(Collection $entities, array $properties, LocaleInterface $targetLocale)
    {
        $entities->map(function (LocaleAwareInterface $entity) use ($properties, $targetLocale) {
            $this->duplicateTranslatableEntity($entity, $properties, $targetLocale);
        });
    }
    
    private function duplicateTranslatableEntity(LocaleAwareInterface $entity, array $properties, LocaleInterface $targetLocale)
    {
        $duplicate = clone $entity;
        foreach ($properties as $propertyName) {
            $value = sprintf('%s-%s', $this->propertyAccessor->getValue($entity, $propertyName), $targetLocale->getCode());
            $this->propertyAccessor->setValue($duplicate, $propertyName, $value);
            $duplicate->setLocale($targetLocale->getCode());
            $this->doctrineHelper->getEntityManager()->persist($duplicate);
        }
    }
}
