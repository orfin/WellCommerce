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
namespace WellCommerce\Bundle\DataGridBundle;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\DataGridBundle\Column\ColumnCollection;
use WellCommerce\Bundle\DataGridBundle\Conditions\ConditionsResolver;
use WellCommerce\Bundle\DataGridBundle\Configuration\EventHandler\ClickRowEventHandler;
use WellCommerce\Bundle\DataGridBundle\Configuration\EventHandler\DeleteRowEventHandler;
use WellCommerce\Bundle\DataGridBundle\Configuration\EventHandler\EditRowEventHandler;
use WellCommerce\Bundle\DataGridBundle\Configuration\EventHandler\LoadEventHandler;
use WellCommerce\Bundle\DataGridBundle\Options\Options;
use WellCommerce\Bundle\DataGridBundle\Options\OptionsInterface;
use WellCommerce\Bundle\CoreBundle\DataSet\DataSetInterface;
use WellCommerce\Bundle\CoreBundle\DataSet\Request\DataSetRequest;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;

/**
 * Class AbstractDataGrid
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractDataGrid extends ContainerAware
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
     * @param DataSetInterface $dataset
     */
    public function __construct(
        $identifier,
        DataSetInterface $dataset
    ) {
        $this->identifier = $identifier;
        $this->dataset    = $dataset;
        $this->columns    = new ColumnCollection();
        $this->options    = new Options();
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
            'route'    => $this->getRouteForAction('grid'),
        ]));

        $eventHandlers->add(new EditRowEventHandler([
            'function'   => $this->getJavascriptFunctionName('edit'),
            'row_action' => DataGridInterface::ACTION_EDIT,
            'route'      => $this->getRouteForAction('edit'),
        ]));

        $eventHandlers->add(new ClickRowEventHandler([
            'function' => $this->getJavascriptFunctionName('click'),
            'route'    => $this->getRouteForAction('edit'),
        ]));

        $eventHandlers->add(new DeleteRowEventHandler([
            'function'   => $this->getJavascriptFunctionName('delete'),
            'row_action' => DataGridInterface::ACTION_DELETE,
            'route'      => $this->getRouteForAction('delete'),
        ]));
    }

    /**
     * {@inheritdoc}
     */
    protected function getRouteForAction($action)
    {
        return $this->container->get('redirect_helper')->getActionForCurrentController($action);
    }

    /**
     * Translates the message using translator service
     *
     * @param $message
     *
     * @return string
     */
    protected function trans($message)
    {
        return $this->get('translator')->trans($message);
    }

    /**
     * Returns service by its id
     *
     * @param string $id
     *
     * @return object
     */
    protected function get($id)
    {
        return $this->container->get($id);
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
        $conditionsResolver = new ConditionsResolver();

        $datasetRequest = new DataSetRequest([
            'id'         => $request->request->get('id'),
            'offset'     => $request->request->get('starting_from'),
            'limit'      => $request->request->get('limit'),
            'orderBy'    => $request->request->get('order_by'),
            'orderDir'   => $request->request->get('order_dir'),
            'conditions' => $conditionsResolver->resolve($request->request->get('where')),
        ]);

        return $this->dataset->getResults($datasetRequest);
    }
}
