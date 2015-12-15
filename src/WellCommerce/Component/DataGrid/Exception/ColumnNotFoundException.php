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

namespace WellCommerce\Component\DataGrid\Exception;

/**
 * Class ColumnNotFoundException
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ColumnNotFoundException extends \InvalidArgumentException
{
    /**
     * Constructor
     *
     * @param string $column
     */
    public function __construct($column)
    {
        parent::__construct(sprintf('DataGrid column "%s" not found', $column));
    }
}
