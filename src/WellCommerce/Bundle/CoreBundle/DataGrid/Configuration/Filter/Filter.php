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
        $this->values = $this->parseValues($values);
    }

    /**
     * Prepares values to use them in DataGrid filter
     *
     * @param $values
     *
     * @return array
     */
    private function parseValues($values)
    {
        $filterOptions = [];
        foreach ($values as $key => $value) {
            $filterOptions[] = [
                'id'    => $key,
                'value' => $value
            ];
        }

        return $filterOptions;
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