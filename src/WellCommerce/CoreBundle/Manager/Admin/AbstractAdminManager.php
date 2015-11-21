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

namespace WellCommerce\CoreBundle\Manager\Admin;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\AdminBundle\Entity\UserInterface;
use WellCommerce\CoreBundle\EventDispatcher\EventDispatcherInterface;
use WellCommerce\CoreBundle\Exception\MissingDataGridException;
use WellCommerce\CoreBundle\Factory\FactoryInterface;
use WellCommerce\CoreBundle\Manager\AbstractManager;
use WellCommerce\CoreBundle\Repository\RepositoryInterface;
use WellCommerce\CoreBundle\Component\DataGrid\DataGridInterface;
use WellCommerce\CoreBundle\Component\Form\FormBuilderInterface;

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
     * Constructor
     *
     * @param RepositoryInterface       $repository
     * @param EventDispatcherInterface  $eventDispatcher
     * @param FactoryInterface|null     $factory
     * @param FormBuilderInterface|null $formBuilder
     * @param DataGridInterface|null    $dataGrid
     */
    public function __construct(
        RepositoryInterface $repository,
        EventDispatcherInterface $eventDispatcher,
        FactoryInterface $factory = null,
        FormBuilderInterface $formBuilder = null,
        DataGridInterface $dataGrid = null
    ) {
        parent::__construct($repository, $eventDispatcher, $factory, $formBuilder);
        $this->dataGrid = $dataGrid;
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
    public function getShopContext()
    {
        return $this->get('shop.context.admin');
    }

    /**
     * {@inheritdoc}
     */
    public function getAdmin()
    {
        $user = $this->getUser();

        if ($user instanceof UserInterface) {
            return $user;
        }

        return null;
    }
}
