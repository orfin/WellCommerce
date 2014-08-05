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

namespace WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\Filter;

/**
 * Class Filter
 *
 * @package WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\Filter
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Filter implements FilterInterface
{

    /**
     * @var string
     */
    private $column;

    /**
     * @var array
     */
    private $values;

    /**
     * Constructor
     *
     * @param $column
     * @param $values
     */
    public function __construct($column, $values)
    {
        $this->column = $column;
        $this->values = $values;
    }

    /**
     * {@inheritdoc}
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * {@inheritdoc}
     */
    public function getValues()
    {
        return $this->values;
    }
} 