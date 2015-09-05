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

namespace WellCommerce\Bundle\AdminBundle\Manager;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\EventDispatcher\EventDispatcherInterface;
use WellCommerce\Bundle\CoreBundle\Exception\MissingDataGridException;
use WellCommerce\Bundle\CoreBundle\Exception\MissingFormBuilderException;
use WellCommerce\Bundle\CoreBundle\Factory\FactoryInterface;
use WellCommerce\Bundle\CoreBundle\Manager\AbstractManager;
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;
use WellCommerce\Bundle\DataGridBundle\DataGridInterface;
use WellCommerce\Bundle\FormBundle\FormBuilderInterface;

/**
 * Class AbstractAdminManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractAdminManager extends AbstractManager implements AdminManagerInterface
{
    /**
     * @var DataGridInterface
     */
    private $dataGrid;

    /**
     * @var FormBuilderInterface
     */
    private $formBuilder;

    /**
     * Constructor
     *
     * @param RepositoryInterface|null      $repository
     * @param DataGridInterface|null        $dataGrid
     * @param FormBuilderInterface|null     $formBuilder
     * @param FactoryInterface|null         $factory
     * @param EventDispatcherInterface|null $eventDispatcher
     */
    public function __construct(
        RepositoryInterface $repository = null,
        DataGridInterface $dataGrid = null,
        FormBuilderInterface $formBuilder = null,
        FactoryInterface $factory = null,
        EventDispatcherInterface $eventDispatcher = null
    ) {
        parent::__construct($repository, $factory, $eventDispatcher);
        $this->dataGrid    = $dataGrid;
        $this->formBuilder = $formBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getDataGrid()
    {
        if (null === $this->dataGrid) {
            throw new MissingDataGridException(get_class($this));
        }

        return $this->dataGrid;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormBuilder()
    {
        if (null === $this->formBuilder) {
            throw new MissingFormBuilderException(get_class($this));
        }

        return $this->formBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getForm($resource, array $config = [])
    {
        $defaultConfig = [
            'name' => $this->getRepository()->getAlias(),
        ];

        $config = array_merge($defaultConfig, $config);

        return $this->formBuilder->createForm($config, $resource);
    }

    /**
     * {@inheritdoc}
     */
    public function findResource(Request $request)
    {
        $this->getDoctrineHelper()->disableFilter('locale');

        if (!$request->attributes->has('id')) {
            throw new \LogicException('Request does not have "id" attribute set.');
        }

        $id       = $request->attributes->get('id');
        $resource = $this->getRepository()->find($id);

        return $resource;
    }

    /**
     * {@inheritdoc}
     */
    public function createResource($resource)
    {
        $this->getEventDispatcher()->dispatchOnPreCreateResource($resource);
        $this->saveResource($resource);
        $this->getEventDispatcher()->dispatchOnPostCreateResource($resource);
    }

    /**
     * {@inheritdoc}
     */
    public function updateResource($resource)
    {
        $this->getEventDispatcher()->dispatchOnPreUpdateResource($resource);
        $this->saveResource($resource);
        $this->getEventDispatcher()->dispatchOnPostUpdateResource($resource);
    }

    /**
     * {@inheritdoc}
     */
    public function removeResource($resource)
    {
        $this->getEventDispatcher()->dispatchOnPreRemoveResource($resource);
        $em = $this->getDoctrineHelper()->getEntityManager();
        $em->remove($resource);
        $em->flush();
        $this->getEventDispatcher()->dispatchOnPostRemoveResource($resource);
    }

    /**
     * {@inheritdoc}
     */
    protected function saveResource($resource)
    {
        $em = $this->getDoctrineHelper()->getEntityManager();
        $em->persist($resource);
        $em->flush();

        return $resource;
    }

    /**
     * {@inheritdoc}
     */
    public function getShopContext()
    {
        return $this->get('shop.context.admin');
    }
}
