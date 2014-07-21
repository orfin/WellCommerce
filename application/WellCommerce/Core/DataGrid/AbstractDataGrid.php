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
namespace WellCommerce\Core\DataGrid;

use phpDocumentor\Descriptor\Filter\Filter;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\Core\AbstractComponent;
use WellCommerce\Core\DataGrid\Column\ColumnCollection;
use WellCommerce\Core\DataGrid\Options\OptionsInterface;
use WellCommerce\Core\DataGrid\Query\QueryInterface;
use WellCommerce\Core\Repository\RepositoryInterface;
use xajaxResponse;

/**
 * Class AbstractDataGrid
 *
 * @package WellCommerce\Core\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractDataGrid extends AbstractComponent
{
    protected $columns;
    protected $identifier;
    protected $repository;
    protected $loader;
    protected $options;
    protected $query;
    protected $container;

    /**
     * Constructor
     *
     * @param ContainerInterface  $container
     * @param RepositoryInterface $repository
     */
    public function __construct(ContainerInterface $container, RepositoryInterface $repository)
    {
        $this->container  = $container;
        $this->repository = $repository;
    }

    public function setColumns(ColumnCollection $columns)
    {
        $this->columns = $columns;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setOptions(OptionsInterface $options)
    {
        $this->options = $options;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setQuery(QueryInterface $query)
    {
        $this->query = $query;
    }

    public function getQuery()
    {
        return $this->query;
    }

    /**
     * {@inheritdoc}
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteRow($request)
    {
        return $this->repository->delete($request['id']);
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
    public function updateRow($request)
    {
        try {
            $this->repository->updateDataGridRow($request);

        } catch (ValidatorException $exception) {
            return [
                'error' => $exception->getMessage()
            ];
        }
    }


    /**
     * {@inheritdoc}
     */
    private function getOperator($operator)
    {
        switch ($operator) {
            case 'NE':
                return '!=';
                break;
            case 'LE':
                return '<=';
                break;
            case 'GE':
                return '>=';
                break;
            case 'LIKE':
                return 'LIKE';
                break;
            case 'IN':
                return '=';
                break;
            default:
                return '=';
        }
    }


}