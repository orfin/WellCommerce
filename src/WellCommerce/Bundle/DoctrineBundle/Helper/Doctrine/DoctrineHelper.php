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
use Doctrine\ORM\Mapping\ClassMetadata;

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
    public function getMetadataFactory()
    {
        return $this->getEntityManager()->getMetadataFactory();
    }

    /**
     * {@inheritdoc}
     */
    public function truncateTable($className)
    {
        $entityManager = $this->getEntityManager();

        $metadata = $this->getClassMetadata($className);
        if ($metadata instanceof ClassMetadata) {
            $connection = $entityManager->getConnection();
            $connection->beginTransaction();
            $table = $metadata->getTableName();

            try {
                $sql  = 'DELETE FROM :table';
                $stmt = $connection->prepare($sql);
                $stmt->bindValue('table', $table);
                $stmt->execute();
                $connection->commit();

                return true;
            } catch (\Exception $e) {
                $connection->rollback();
            }
        }

        return false;
    }
}
