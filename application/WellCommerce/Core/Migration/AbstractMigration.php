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
namespace WellCommerce\Core\Migration;

use WellCommerce\Core\DependencyInjection\ServiceContainer;

/**
 * Class AbstractMigration
 *
 * @package WellCommerce\Core\Migration
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractMigration
{

    /**
     * @var ServiceContainer
     */
    protected $container;

    /**
     * @var string
     */
    protected $migrationClass;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->container = new ServiceContainer();
    }

    /**
     * Shortcut to get Filesystem service
     *
     * @return object
     */
    protected function getFilesystem()
    {
        return $this->container->get('filesystem');
    }

    /**
     * Gets a service by id.
     *
     * @param string $id The service id
     *
     * @return object Service
     */
    protected function get($id)
    {
        return $this->container->get($id);
    }

    protected function getDb()
    {
        return $this->container->get('database_manager');
    }

    protected function getFinder()
    {
        return $this->container->get('finder');
    }
}