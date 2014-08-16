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

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyPath;
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
     * @var string Current locale
     */
    private $currentLocale = null;

    /**
     * Sets current locale for repository
     *
     * @param $currentLocale
     */
    public function setCurrentLocale($currentLocale)
    {
        $this->currentLocale = $currentLocale;
    }

    /**
     * Returns current repository locale
     *
     * @return null|string
     */
    public function getCurrentLocale()
    {
        return $this->currentLocale;
    }

    /**
     * {@inheritdoc}
     */
    public function createNew()
    {
        $entity = $this->getClassName();

        return new $entity;
    }

    protected function getQueryBuilder()
    {
        return $this->createQueryBuilder($this->getAlias());
    }

    /**
     * {@inheritdoc}
     */
    public function deleteRow($id)
    {
        $entity = $this->find($id);
        $this->_em->remove($entity);
        $this->_em->flush();
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

    /**
     * {@inheritdoc}
     */
    public function findResource(Request $request, array $criteria = [])
    {
        $params = [];
        if ($request->attributes->has('id')) {
            $params = [
                'id' => $request->attributes->get('id')
            ];
        }
        if ($request->attributes->has('slug')) {
            $params = [
                'slug' => $request->attributes->get('slug')
            ];
        }

        $criteria = array_merge($params, $criteria);

        if (!$resource = $this->findOneBy($criteria)) {
            throw new EntityNotFoundException($this->getEntityName());
        }

        return $resource;
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadata()
    {
        return $this->_class;
    }

    /**
     * Builds and executes query to fetch collection of items to use in optioned fields
     *
     * @param $identifier
     * @param $labelField
     * @param $targetClass
     * @param $tableName
     * @param $associationTableName
     *
     * @return array
     */
    private function getCollection($identifier, $labelField, $targetClass, $tableName, $associationTableName)
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
            "{$identifierField} = {$associationTableName}.translatable AND {$associationTableName}.locale = :locale");
        $queryBuilder->groupBy($identifierField);
        $queryBuilder->setParameter('locale', $this->getCurrentLocale());
        $query      = $queryBuilder->getQuery();
        $collection = $query->getResult();

        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function getCollectionToSelect($labelField = 'name')
    {
        $metadata   = $this->getMetadata();
        $identifier = $metadata->getSingleIdentifierFieldName();
        $tableName  = $metadata->getTableName();
        $accessor   = PropertyAccess::createPropertyAccessor();
        $select     = [];

        if (!$metadata->hasField($labelField)) {
            if ($metadata->hasAssociation('translations')) {
                $association         = $metadata->getAssociationTargetClass('translations');
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
            $collection = $this->findAll();

            foreach ($collection as $item) {
                $id          = $accessor->getValue($item, $identifier);
                $label       = $accessor->getValue($item, $labelField);
                $select[$id] = $label;
            }

            return $select;
        }

        throw new \InvalidArgumentException('Cannot find field named %s or association named "translations".', $labelField);
    }

    /**
     * {@inheritdoc}
     */
    public function getPropertyAccessor()
    {
        return PropertyAccess::createPropertyAccessor();
    }
}