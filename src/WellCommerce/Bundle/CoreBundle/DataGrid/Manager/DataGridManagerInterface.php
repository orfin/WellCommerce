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

namespace WellCommerce\Bundle\CoreBundle\DataGrid\Manager;

/**
 * Interface DataGridManagerInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\DataGrid\Manager
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DataGridManagerInterface
{

    /**
     * Returns column collection
     *
     * @return \WellCommerce\Bundle\CoreBundle\DataGrid\Column\ColumnCollection
     */
    public function getColumnCollection();

    /**
     * Returns options collection
     *
     * @return \WellCommerce\Bundle\CoreBundle\DataGrid\Options\OptionsInterface
     */
    public function getOptions();

    /**
     * Returns DataGrid loader
     *
     * @return \WellCommerce\Bundle\CoreBundle\DataGrid\Loader\LoaderInterface
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
     * Returns xajax helper
     *
     * @return \WellCommerce\Bundle\CoreBundle\Helper\XajaxManager
     */
    public function getXajaxManager();

    /**
     * Translates message using translator service
     *
     * @param $message
     *
     * @return mixed
     */
    public function translate($message);
} 