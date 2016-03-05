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

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\Bundle\CoreBundle\EventDispatcher\EventDispatcherInterface;
use WellCommerce\Component\DataGrid\Column\ColumnCollection;
use WellCommerce\Component\DataGrid\Configuration\EventHandler\ClickRowEventHandler;
use WellCommerce\Component\DataGrid\Configuration\EventHandler\DeleteRowEventHandler;
use WellCommerce\Component\DataGrid\Configuration\EventHandler\EditRowEventHandler;
use WellCommerce\Component\DataGrid\Configuration\EventHandler\LoadEventHandler;
use WellCommerce\Component\DataGrid\DataGridInterface;
use WellCommerce\Component\DataGrid\Options\Options;
use WellCommerce\Component\DataGrid\Options\OptionsInterface;
use WellCommerce\Component\DataSet\Conditions\ConditionsCollection;
use WellCommerce\Component\DataSet\Conditions\ConditionsResolver;
use WellCommerce\Component\DataSet\DataSetInterface;

/**
 * Class AbstractDataGrid
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractDataGrid extends AbstractContainerAware implements DataGridInterface
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
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

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
     * @param string                   $identifier
     * @param DataSetInterface         $dataset
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct($identifier, DataSetInterface $dataset, EventDispatcherInterface $eventDispatcher)
    {
        $this->identifier      = $identifier;
        $this->dataset         = $dataset;
        $this->eventDispatcher = $eventDispatcher;
        $this->columns         = new ColumnCollection();
        $this->options         = new Options();
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

    /**
     * Boots current datagrid
     */
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
            'route'    => $this->getActionUrl('grid'),
        ]));

        $eventHandlers->add(new EditRowEventHandler([
            'function'   => $this->getJavascriptFunctionName('edit'),
            'row_action' => DataGridInterface::ACTION_EDIT,
            'route'      => $this->getActionUrl('edit'),
        ]));

        $eventHandlers->add(new ClickRowEventHandler([
            'function' => $this->getJavascriptFunctionName('click'),
            'route'    => $this->getActionUrl('edit'),
        ]));

        $eventHandlers->add(new DeleteRowEventHandler([
            'function'   => $this->getJavascriptFunctionName('delete'),
            'row_action' => DataGridInterface::ACTION_DELETE,
            'route'      => $this->getActionUrl('delete'),
        ]));
    }

    /**
     * Returns an absolute URL pointing to controller action
     *
     * @param $actionName
     *
     * @return string
     */
    protected function getActionUrl($actionName)
    {
        return $this->getRouterHelper()->getActionForCurrentController($actionName);
    }

    /**
     * Returns javascript function name
     *
     * @param $name
     *
     * @return string
     */
    protected function getJavascriptFunctionName($name)
    {
        $functionName = sprintf('%s%s', $name, ucfirst($this->identifier));
        $functionName = ucwords(str_replace(['-', '_'], ' ', $functionName));
        $functionName = str_replace(' ', '', $functionName);

        return lcfirst($functionName);
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
        $page               = ($request->request->get('starting_from') / $request->request->get('limit')) + 1;
        $conditions         = new ConditionsCollection();
        $conditionsResolver = new ConditionsResolver();
        $conditionsResolver->resolveConditions($request->request->get('where'), $conditions);

        $requestOptions = [
            'page'       => $page,
            'limit'      => $request->request->get('limit'),
            'order_by'   => $request->request->get('order_by'),
            'order_dir'  => $request->request->get('order_dir'),
            'conditions' => $conditions,
        ];

        return $this->dataset->getResult('datagrid', $requestOptions);
    }
}
