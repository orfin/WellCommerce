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

use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\Bundle\CoreBundle\EventDispatcher\EventDispatcherInterface;
use WellCommerce\Bundle\CoreBundle\Exception\MissingFactoryException;
use WellCommerce\Bundle\CoreBundle\Exception\MissingFormBuilderException;
use WellCommerce\Bundle\DoctrineBundle\Factory\EntityFactoryInterface;
use WellCommerce\Bundle\DoctrineBundle\Repository\RepositoryInterface;
use WellCommerce\Component\Form\Elements\FormInterface;
use WellCommerce\Component\Form\FormBuilderInterface;

/**
 * Class AbstractManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractManager extends AbstractContainerAware implements ManagerInterface
{
    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var EntityFactoryInterface
     */
    protected $factory;

    /**
     * @var FormBuilderInterface
     */
    private $formBuilder;

    /**
     * Constructor
     *
     * @param RepositoryInterface         $repository
     * @param EventDispatcherInterface    $eventDispatcher
     * @param EntityFactoryInterface|null $factory
     * @param FormBuilderInterface|null   $formBuilder
     */
    public function __construct(
        RepositoryInterface $repository,
        EventDispatcherInterface $eventDispatcher,
        EntityFactoryInterface $factory = null,
        FormBuilderInterface $formBuilder = null
    ) {
        $this->repository      = $repository;
        $this->eventDispatcher = $eventDispatcher;
        $this->factory         = $factory;
        $this->formBuilder     = $formBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getRepository() : RepositoryInterface
    {
        return $this->repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getEventDispatcher() : EventDispatcherInterface
    {
        return $this->eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function getFactory() : EntityFactoryInterface
    {
        if (null === $this->factory) {
            throw new MissingFactoryException(get_class($this));
        }

        return $this->factory;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormBuilder() : FormBuilderInterface
    {
        if (null === $this->formBuilder) {
            throw new MissingFormBuilderException(get_class($this));
        }

        return $this->formBuilder;
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
    public function initResource()
    {
        $resource = $this->factory->create();
        $this->eventDispatcher->dispatchOnPostInitResource($resource);

        return $resource;
    }

    /**
     * {@inheritdoc}
     */
    public function createResource($resource)
    {
        $this->eventDispatcher->dispatchOnPreCreateResource($resource);
        $this->saveResource($resource);
        $this->eventDispatcher->dispatchOnPostCreateResource($resource);
    }

    /**
     * {@inheritdoc}
     */
    public function updateResource($resource)
    {
        $this->eventDispatcher->dispatchOnPreUpdateResource($resource);
        $this->saveResource($resource);
        $this->eventDispatcher->dispatchOnPostUpdateResource($resource);
    }

    /**
     * {@inheritdoc}
     */
    public function removeResource($resource)
    {
        $this->eventDispatcher->dispatchOnPreRemoveResource($resource);
        $em = $this->getDoctrineHelper()->getEntityManager();
        $em->remove($resource);
        $em->flush();
        $this->eventDispatcher->dispatchOnPostRemoveResource($resource);
    }

    /**
     * {@inheritdoc}
     */
    protected function saveResource($resource)
    {
        $em = $this->getEntityManager();
        $em->persist($resource);
        $em->flush();

        return $resource;
    }
}
