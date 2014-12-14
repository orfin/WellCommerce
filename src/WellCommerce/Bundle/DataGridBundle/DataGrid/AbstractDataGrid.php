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
namespace WellCommerce\Bundle\DataGridBundle\DataGrid;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;
use WellCommerce\Bundle\DataGridBundle\DataGrid\Column\ColumnCollection;
use WellCommerce\Bundle\DataGridBundle\DataGrid\Configuration\EventHandler\ClickRowEventHandler;
use WellCommerce\Bundle\DataGridBundle\DataGrid\Configuration\EventHandler\DeleteRowEventHandler;
use WellCommerce\Bundle\DataGridBundle\DataGrid\Configuration\EventHandler\EditRowEventHandler;
use WellCommerce\Bundle\DataGridBundle\DataGrid\Configuration\EventHandler\LoadEventHandler;
use WellCommerce\Bundle\DataGridBundle\DataGrid\Options\OptionsInterface;
use WellCommerce\Bundle\DataSetBundle\DataSet\DataSetInterface;
use WellCommerce\Bundle\DataSetBundle\DataSet\Request\DataSetRequest;

/**
 * Class AbstractDataGrid
 *
 * @package WellCommerce\Bundle\DataGridBundle\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractDataGrid
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var ColumnCollection
     */
    protected $columns;

    /**
     * @var OptionsInterface
     */
    protected $options;

    /**
     * @var DataSetInterface
     */
    protected $dataset;

    /**
     * @var bool
     */
    protected $booted = false;

    /**
     * Constructor
     *
     * @param                  $identifier
     * @param ColumnCollection $columns
     * @param DataSetInterface $dataset
     */
    public function __construct(
        $identifier,
        ColumnCollection $columns,
        OptionsInterface $options,
        DataSetInterface $dataset
    ) {
        $this->identifier = $identifier;
        $this->columns    = $columns;
        $this->options    = $options;
        $this->dataset    = $dataset;
    }

    /**
     * Returns current DataGrid
     *
     * @return DataGridInterface
     */
    public function getInstance()
    {
        if (!$this->booted) {
            $this->configure();
        }

        return $this;
    }

    protected function configure()
    {
        $this->configureColumns($this->columns);
        $this->configureOptions($this->options);
        $this->booted = true;
    }

    /**
     * Configures DataGrid columns
     *
     * @param ColumnCollection $columns
     *
     * @return void
     */
    abstract protected function configureColumns(ColumnCollection $columns);

    /**
     * Configures DataGrid options
     *
     * @param OptionsInterface $options
     *
     * @return void
     */
    protected function configureOptions(OptionsInterface $options)
    {
        $eventHandlers = $options->getEventHandlers();

        $eventHandlers->add(new LoadEventHandler([
            'function' => $this->getJavascriptFunctionName('load'),
            'route'    => $options->getRouteForAction('grid')
        ]));

        $eventHandlers->add(new EditRowEventHandler([
            'function'   => $this->getJavascriptFunctionName('edit'),
            'row_action' => DataGridInterface::ACTION_EDIT,
            'route'      => $options->getRouteForAction('edit')
        ]));

        $eventHandlers->add(new ClickRowEventHandler([
            'function' => $this->getJavascriptFunctionName('click'),
            'route'    => $options->getRouteForAction('edit')
        ]));

        $eventHandlers->add(new DeleteRowEventHandler([
            'function'   => $this->getJavascriptFunctionName('delete'),
            'row_action' => DataGridInterface::ACTION_DELETE,
            'route'      => $options->getRouteForAction('delete')
        ]));
    }

    protected function getJavascriptFunctionName($name)
    {
        $functionName = sprintf('%s%s', $name, ucfirst($this->identifier));

        return lcfirst(Helper::studly($functionName));
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
    public function setColumns(ColumnCollection $columns)
    {
        $this->columns = $columns;
    }

    /**
     * {@inheritdoc}
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions(OptionsInterface $options)
    {
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function loadResults(Request $request)
    {
        $datasetRequest = new DataSetRequest([
            'id'         => $request->request->get('id'),
            'offset'     => $request->request->get('starting_from'),
            'limit'      => $request->request->get('limit'),
            'orderBy'    => $request->request->get('order_by'),
            'orderDir'   => $request->request->get('order_dir'),
            'conditions' => null
        ]);

        return $this->dataset->getResults($datasetRequest);
    }
}