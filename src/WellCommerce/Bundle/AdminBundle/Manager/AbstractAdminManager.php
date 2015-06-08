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
use WellCommerce\Bundle\DataGridBundle\DataGridInterface;
use WellCommerce\Bundle\FormBundle\Builder\FormBuilderInterface;

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
    private $datagrid;

    /**
     * @var FormBuilderInterface
     */
    private $formBuilder;

    /**
     * {@inheritdoc}
     */
    public function setDataGrid(DataGridInterface $datagrid)
    {
        $this->datagrid = $datagrid;
    }

    /**
     * {@inheritdoc}
     */
    public function getDataGrid()
    {
        return $this->datagrid->getInstance();
    }

    /**
     * {@inheritdoc}
     */
    public function setFormBuilder(FormBuilderInterface $formBuilder)
    {
        $this->formBuilder = $formBuilder;
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
}
