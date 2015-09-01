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
    protected $dataGrid;

    /**
     * @var FormBuilderInterface
     */
    protected $formBuilder;

    /**
     * Constructor
     *
     * @param RepositoryInterface       $repository
     * @param DataGridInterface|null    $dataGrid
     * @param FormBuilderInterface|null $formBuilder
     */
    public function __construct(RepositoryInterface $repository, DataGridInterface $dataGrid = null, FormBuilderInterface $formBuilder = null)
    {
        parent::__construct($repository);
        $this->dataGrid    = $dataGrid;
        $this->formBuilder = $formBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getDataGrid()
    {
        return $this->dataGrid;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormBuilder()
    {
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
    public function getShopContext()
    {
        return $this->get('shop.context.admin');
    }
}
