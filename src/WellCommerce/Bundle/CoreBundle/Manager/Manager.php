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
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class Manager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class Manager implements ManagerInterface
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
    private $doctrineHelper;

    /**
     * Manager constructor.
     *
     * @param RepositoryInterface     $repository
     * @param EntityFactoryInterface  $factory
     * @param DoctrineHelperInterface $doctrineHelper
     */
    public function __construct(RepositoryInterface $repository, EntityFactoryInterface $factory, DoctrineHelperInterface $doctrineHelper)
    {
        $this->repository     = $repository;
        $this->factory        = $factory;
        $this->doctrineHelper = $doctrineHelper;
    }

    public function getRepository() : RepositoryInterface
    {
        return $this->repository;
    }

    public function getFactory() : EntityFactoryInterface
    {
        return $this->factory;
    }

    public function getForm($resource, array $config = []) : FormInterface
    {
        $builder       = $this->getFormBuilder();
        $defaultConfig = [
            'name'              => $this->repository->getAlias(),
            'validation_groups' => ['Default']
        ];
        $config        = array_merge($defaultConfig, $config);

        return $builder->createForm($config, $resource);
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
        return $this->doctrineHelper;
    }

    private function getEntityManager() : ObjectManager
    {
        return $this->doctrineHelper->getEntityManager();
    }
}
