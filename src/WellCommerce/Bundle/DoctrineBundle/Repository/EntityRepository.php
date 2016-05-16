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
namespace WellCommerce\Bundle\DoctrineBundle\Repository;

use Doctrine\ORM\EntityRepository as BaseEntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;

/**
 * Class EntityRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class EntityRepository extends BaseEntityRepository implements RepositoryInterface
{
    const TRANSLATIONS_ASSOCIATION_NAME  = 'translations';
    const TRANSLATIONS_ASSOCIATION_FIELD = 'translatable';

    public function getMetadata() : ClassMetadata
    {
        return $this->_class;
    }

    public function getAlias() : string
    {
        $parts      = explode('\\', $this->getEntityName());
        $entityName = end($parts);

        return Helper::snake($entityName);
    }

    public function getDataSetQueryBuilder() : QueryBuilder
    {
        $queryBuilder    = $this->getQueryBuilder();
        $metadata        = $this->getMetadata();
        $identifierField = sprintf('%s.%s', $metadata->getTableName(), $metadata->getSingleIdentifierFieldName());

        if ($metadata->hasAssociation(self::TRANSLATIONS_ASSOCIATION_NAME)) {
            $association          = $metadata->getAssociationTargetClass(self::TRANSLATIONS_ASSOCIATION_NAME);
            $associationMetaData  = $this->getEntityManager()->getClassMetadata($association);
            $associationTableName = $associationMetaData->getTableName();
            $translationField     = sprintf('%s.%s', $associationTableName, self::TRANSLATIONS_ASSOCIATION_FIELD);

            $queryBuilder->leftJoin(
                $association,
                $associationMetaData->getTableName(),
                'WITH',
                "{$identifierField} = {$translationField}"
            );
        }

        return $queryBuilder;
    }

    public function getQueryBuilder() : QueryBuilder
    {
        return $this->createQueryBuilder($this->getAlias());
    }

    public function getTotalCount() : int
    {
        $queryBuilder = $this->getQueryBuilder();
        $query        = $queryBuilder->getQuery();
        $query->useQueryCache(true);
        $query->useResultCache(true);
        $paginator = new Paginator($query, true);
        $paginator->setUseOutputWalkers(false);

        return $paginator->count();
    }
}
