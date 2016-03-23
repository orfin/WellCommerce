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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\PropertyAccess\PropertyAccess;
use WellCommerce\Bundle\DoctrineBundle\Helper\Doctrine\DoctrineHelperInterface;
use WellCommerce\Bundle\LocaleBundle\Entity\LocaleAwareInterface;
use WellCommerce\Bundle\LocaleBundle\Entity\LocaleInterface;

/**
 * Class LocaleCopier
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LocaleCopier implements LocaleCopierInterface
{
    /**
     * @var DoctrineHelperInterface
     */
    protected $doctrineHelper;

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager|object
     */
    protected $entityManager;

    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected $propertyAccessor;

    /**
     * LocaleCopier constructor.
     *
     * @param DoctrineHelperInterface $doctrineHelper
     */
    public function __construct(DoctrineHelperInterface $doctrineHelper)
    {
        $this->doctrineHelper   = $doctrineHelper;
        $this->entityManager    = $doctrineHelper->getEntityManager();
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();

    }

    public function copyLocaleData(LocaleInterface $sourceLocale, LocaleInterface $targetLocale)
    {
        $repositories = $this->getTranslatableRespositories();

        $repositories->map(function (EntityRepository $repository) use ($sourceLocale, $targetLocale) {
            $this->copyTranslatableEntities($repository, $sourceLocale, $targetLocale);
        });

        $this->entityManager->flush();
    }

    protected function copyTranslatableEntities(EntityRepository $repository, LocaleInterface $sourceLocale, LocaleInterface $targetLocale)
    {
        $entities = $this->findTranslatableEntities($repository, $sourceLocale);

        $entities->map(function (LocaleAwareInterface $entity) use ($targetLocale) {
            $this->copyTranslatableEntity($entity, $targetLocale);
        });
    }

    protected function copyTranslatableEntity(LocaleAwareInterface $entity, LocaleInterface $targetLocale)
    {
        $duplicate = clone $entity;
        foreach ($entity->getCopyingSensitiveProperties() as $propertyName) {
            $value = sprintf('%s-%s', $this->propertyAccessor->getValue($entity, $propertyName), $targetLocale->getCode());
            $this->propertyAccessor->setValue($duplicate, $propertyName, $value);
            $duplicate->setLocale($targetLocale->getCode());
            $this->entityManager->persist($duplicate);
        }
    }

    protected function getTranslatableRespositories() : Collection
    {
        $collection = new ArrayCollection();
        $metadata   = $this->doctrineHelper->getAllMetadata();
        foreach ($metadata as $classMetadata) {
            $reflectionClass = $classMetadata->getReflectionClass();
            if ($reflectionClass->implementsInterface(LocaleAwareInterface::class)) {
                $repository = $this->entityManager->getRepository($reflectionClass->getName());
                $collection->add($repository);
            }
        }

        return $collection;
    }

    protected function findTranslatableEntities(EntityRepository $repository, LocaleInterface $locale) : Collection
    {
        $criteria = new Criteria();
        $criteria->where($criteria->expr()->eq('locale', $locale->getCode()));
        $collection = $repository->matching($criteria);

        return $collection;
    }
}
