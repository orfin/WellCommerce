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

namespace WellCommerce\Bundle\CoreBundle\DataGrid\Configurator;

use WellCommerce\Bundle\CoreBundle\DataGrid\Column\ColumnCollection;
use WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\Manager\DataGridManagerInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\Options\OptionsInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\QueryBuilder\QueryBuilderInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\Repository\DataGridAwareRepositoryInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;

/**
 * Class AbstractConfigurator
 *
 * @package WellCommerce\Bundle\CoreBundle\DataGrid\Configurator
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AbstractConfigurator implements ConfiguratorInterface
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var DataGridManagerInterface
     */
    protected $manager;

    /**
     * @var DataGridAwareRepositoryInterface
     */
    protected $repository;

    /**
     * Constructor
     *
     * @param                                  $identifier
     * @param DataGridManagerInterface         $manager
     * @param DataGridAwareRepositoryInterface $repository
     */
    public function __construct($identifier, DataGridManagerInterface $manager, DataGridAwareRepositoryInterface $repository)
    {
        $this->identifier = $identifier;
        $this->manager    = $manager;
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function configure(DataGridInterface $dataGrid)
    {
        $dataGrid->setIdentifier($this->identifier);

        $dataGrid->setColumns($this->manager->getColumnCollection());
    }

    /**
     * Returns a function name used in DataGrid events and actions
     *
     * @param $name
     *
     * @return string
     */
    protected function getFunction($name)
    {
        $functionName = sprintf('%s%s', $name, ucfirst($this->identifier));

        return lcfirst(Helper::studly($functionName));
    }
}