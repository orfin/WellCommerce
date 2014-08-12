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
namespace WellCommerce\Bundle\CoreBundle\DataGrid;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\ColumnCollection;
use WellCommerce\Bundle\CoreBundle\DataGrid\Manager\DataGridManagerInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\Options\OptionsInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\Repository\DataGridAwareRepositoryInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\Request\Request;
use WellCommerce\Bundle\CoreBundle\DataGrid\Request\RequestInterface;
use xajaxResponse;

/**
 * Class AbstractDataGrid
 *
 * @package WellCommerce\Bundle\CoreBundle\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractDataGrid implements DataGridInterface
{
    protected $columns;
    protected $identifier;

    /**
     * @var DataGridAwareRepositoryInterface
     */
    protected $repository;
    protected $loader;
    protected $options;
    protected $queryBuilder;
    protected $request;

    /**
     * @var DataGridManagerInterface
     */
    protected $manager;

    /**
     * {@inheritdoc}
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * {@inheritdoc}
     */
    public function setManager(DataGridManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * {@inheritdoc}
     */
    public function setRepository(DataGridAwareRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getRepository()
    {
        return $this->repository;
    }

    public function setColumns(ColumnCollection $columns)
    {
        $this->columns = $columns;
    }

    public function getColumns()
    {
        return $this->manager->getColumnCollection();
    }

    public function init()
    {
        $columnCollection = $this->manager->getColumnCollection();

        // adds new columns do collection
        $this->addColumns($columnCollection);

        // sets columns for current datagrid
        $this->setColumns($columnCollection);

        $this->setOptions($this->manager->getOptions());

        return $this;
    }

    protected function trans($message)
    {
        return $this->manager->translate($message);
    }


    public function setOptions(OptionsInterface $options)
    {
        $this->options = $options;
    }

    public function getOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function getDataGridQueryBuilder()
    {
        return $this->repository->getDataGridQueryBuilder();
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrentRequest(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentRequest()
    {
        return $this->request;
    }

    /**
     * {@inheritdoc}
     */
    public function refresh($datagridId)
    {
        $objResponse = new xajaxResponse();
        $objResponse->script('' . 'try {' . 'GF_Datagrid.ReturnInstance(' . (int)$datagridId . ').LoadData();' . '}' . 'catch (xException) {' . 'GF_Debug.HandleException(xException);' . '}' . '');

        return $objResponse;
    }

    /**
     * {@inheritdoc}
     */
    public function update(array $request)
    {
        try {
            $this->repository->updateRow($request);

        } catch (ValidatorException $exception) {
            return [
                'error' => $exception->getMessage()
            ];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function delete($request)
    {
        return $this->repository->deleteRow($request['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $options)
    {
        $this->setCurrentRequest(new Request([
            'id'            => $options['id'],
            'starting_from' => (int)$options['starting_from'],
            'limit'         => (int)$options['limit'],
            'order_by'      => $options['order_by'],
            'order_dir'     => $options['order_dir'],
            'where'         => $options['where']
        ]));

        return $this->manager->getLoader()->getResults($this);
    }
}