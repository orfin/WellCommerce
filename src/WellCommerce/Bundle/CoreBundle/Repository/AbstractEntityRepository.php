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
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractEntityRepository extends EntityRepository implements RepositoryInterface
{
    const TRANSLATIONS_ASSOCIATION_NAME  = 'translations';
    const TRANSLATIONS_ASSOCIATION_FIELD = 'translatable';

    /**
     * {@inheritdoc}
     */
    public function getLocales()
    {
        return $this->getRepository('WellCommerce\Bundle\IntlBundle\Entity\Locale')->findAll();
    }

    /**
     * Returns class metadata
     *
     * @return \Doctrine\ORM\Mapping\ClassMetadata
     */
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

        return new $entity();
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
    public function getAlias()
    {
        $parts      = explode('\\', $this->getEntityName());
        $entityName = end($parts);

        return Helper::snake($entityName);
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadataFactory()
    {
        return $this->getEntityManager()->getMetadataFactory();
    }

    /**
     * Returns a repository by class name
     *
     * @param string $class
     *
     * @return RepositoryInterface
     */
    protected function getRepository($class)
    {
        return $this->getEntityManager()->getRepository($class);
    }

    public function getDataSetQueryBuilder()
    {
        $queryBuilder    = $this->getQueryBuilder();
        $metadata        = $this->getMetadata();
        $identifierField = sprintf('%s.%s', $metadata->getTableName(), $metadata->getSingleIdentifierFieldName());

        if ($metadata->hasAssociation(self::TRANSLATIONS_ASSOCIATION_NAME)) {
            $association      = $metadata->getAssociationTargetClass(self::TRANSLATIONS_ASSOCIATION_NAME);
            $associationMetaData  = $this->getEntityManager()->getClassMetadata($association);
            $associationTableName = $associationMetaData->getTableName();
            $translationField = sprintf('%s.%s', $associationTableName, self::TRANSLATIONS_ASSOCIATION_FIELD);

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
     * Creates QueryBuilder instance
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function getQueryBuilder()
    {
        return $this->createQueryBuilder($this->getAlias());
    }
}
