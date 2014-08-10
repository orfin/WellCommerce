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
use WellCommerce\Bundle\CoreBundle\DataGrid\Options\OptionsInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\QueryBuilder\QueryBuilderInterface;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainer;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;

/**
 * Class AbstractConfigurator
 *
 * @package WellCommerce\Bundle\CoreBundle\DataGrid\Configurator
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AbstractConfigurator extends AbstractContainer
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var OptionsInterface
     */
    protected $options;

    /**
     * @var ColumnCollection
     */
    protected $columns;

    /**
     * @var QueryBuilderInterface
     */
    protected $queryBuilder;

    /**
     * Constructor
     *
     * @param                       $identifier
     * @param OptionsInterface      $options
     * @param ColumnCollection      $columns
     */
    public function __construct($identifier, OptionsInterface $options, ColumnCollection $columns)
    {
        $this->identifier   = $identifier;
        $this->options      = $options;
        $this->columns      = $columns;
    }

    /**
     * Returns a function name used in DataGrid events and actions
     *
     * @param $name
     *
     * @return string
     */
    public function getFunction($name)
    {
        $functionName = sprintf('%s%s', $name, ucfirst($this->identifier));

        return lcfirst(Helper::studly($functionName));
    }

}