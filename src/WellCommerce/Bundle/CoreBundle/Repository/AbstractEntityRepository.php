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

use Doctrine\ORM\EntityRepository;
use Symfony\Component\PropertyAccess\PropertyAccess;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;

/**
 * Class AbstractEntityRepository
 *
 * @package WellCommerce\Bundle\CoreBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractEntityRepository extends EntityRepository implements RepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getLocales()
    {
        return $this->getRepository('WellCommerce\Bundle\IntlBundle\Entity\Locale')->findAll();
    }

    /**
     * Returns a repository by entity class
     *
     * @param $name
     *
     * @return RepositoryInterface
     */
    protected function getRepository($name)
    {
        return $this->getEntityManager()->getRepository($name);
    }

    public function getMetadata()
    {
        return $this->_class;
    }

    /**
     * {@inheritdoc}
     */
    public function createNew()
    {
        $entity = $this->getClassName();

        return new $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function getCollectionToSelect($labelField = 'name', $associationName = 'translations')
    {
        $metadata   = $this->getClassMetadata();
        $identifier = $metadata->getSingleIdentifierFieldName();
        $tableName  = $metadata->getTableName();
        $accessor   = $this->getPropertyAccessor();
        $select     = [];

        if (!$metadata->hasField($labelField)) {
            if ($metadata->hasAssociation($associationName)) {
                $association         = $metadata->getAssociationTargetClass($associationName);
                $associationMetaData = $this->_em->getClassMetadata($association);
                if ($associationMetaData->hasField($labelField)) {
                    $associationTableName = $associationMetaData->getTableName();

                    $collection = $this->getCollection(
                        $identifier,
                        $labelField,
                        $association,
                        $tableName,
                        $associationTableName
                    );

                    foreach ($collection as $item) {
                        $id          = $accessor->getValue($item, '[' . $identifier . ']');
                        $select[$id] = $accessor->getValue($item, '[' . $labelField . ']');
                    }

                    return $select;
                }
            }
        } else {
            $collection = $this->findBy([], [$labelField => 'asc']);

            foreach ($collection as $item) {
                $id          = $accessor->getValue($item, $identifier);
                $label       = $accessor->getValue($item, $labelField);
                $select[$id] = $label;
            }

            return $select;
        }

        throw new \InvalidArgumentException('Field "%s" or association "%s" not found.', $labelField, $associationName);
    }

    /**
     * {@inheritdoc}
     */
    public function getPropertyAccessor()
    {
        return PropertyAccess::createPropertyAccessor();
    }

    /**
     * {@inheritdoc}
     */
    public function getCollection($identifier, $labelField, $targetClass, $tableName, $associationTableName)
    {
        $identifierField  = sprintf('%s.%s', $tableName, $identifier);
        $translationField = sprintf('%s.%s', $associationTableName, $labelField);
        $queryBuilder     = $this->getQueryBuilder($this->getName());
        $queryBuilder->select("
            {$identifierField},
            {$translationField}
        ");
        $queryBuilder->leftJoin(
            $targetClass,
            $associationTableName,
            "WITH",
            "{$identifierField} = {$associationTableName}.translatable");
        $queryBuilder->groupBy($identifierField);
        $query      = $queryBuilder->getQuery();
        $collection = $query->getResult();

        return $collection;
    }

    protected function getQueryBuilder()
    {
        return $this->createQueryBuilder($this->getAlias());
    }

    public function getDataGridQueryBuilder()
    {
        $queryBuilder    = $this->getQueryBuilder();
        $metadata        = $this->getMetadata();
        $associationName = 'translations';
        $identifierField = sprintf('%s.%s', $metadata->getTableName(), $metadata->getSingleIdentifierFieldName());

        if ($metadata->hasAssociation($associationName)) {
            $association          = $metadata->getAssociationTargetClass($associationName);
            $associationMetaData  = $this->getEntityManager()->getClassMetadata($association);
            $associationTableName = $associationMetaData->getTableName();
            $translationField     = sprintf('%s.%s', $associationTableName, 'translatable');

            $queryBuilder->leftJoin(
                $association,
                $associationMetaData->getTableName(),
                'WITH',
                "{$identifierField} = {$translationField}"
            );

        }

        return $queryBuilder;

    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        $parts      = explode('\\', $this->getEntityName());
        $entityName = end($parts);

        return Helper::snake($entityName);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getEntityName();
    }
}