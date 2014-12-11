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

namespace WellCommerce\Bundle\DataGridBundle\DataGrid\Manager;

/**
 * Interface DataGridManagerInterface
 *
 * @package WellCommerce\Bundle\DataGridBundle\DataGrid\Manager
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DataGridManagerInterface
{

    /**
     * Returns column collection
     *
     * @return \WellCommerce\Bundle\DataGridBundle\DataGrid\Column\ColumnCollection
     */
    public function getColumnCollection();

    /**
     * Returns options collection
     *
     * @return \WellCommerce\Bundle\DataGridBundle\DataGrid\Options\OptionsInterface
     */
    public function getOptions();

    /**
     * Returns DataGrid loader
     *
     * @return \WellCommerce\Bundle\DataGridBundle\DataGrid\Loader\LoaderInterface
     */
    public function getLoader();

    /**
     * Returns event dispatcher
     *
     * @return \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    public function getEventDispatcher();

    /**
     * Returns router service
     *
     * @return \Symfony\Component\Routing\RouterInterface
     */
    public function getRouter();

    /**
     * Returns a route for given action in scope of current controller
     *
     * @param $action
     *
     * @return mixed
     */
    public function getRouteForAction($action);

    /**
     * Returns image path using helper service
     *
     * @param       $path
     * @param       $filter
     * @param array $config
     *
     * @return mixed
     */
    public function getImage($path, $filter, array $config = []);
} 