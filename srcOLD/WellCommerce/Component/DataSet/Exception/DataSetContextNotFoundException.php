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

namespace WellCommerce\Component\DataSet\Exception;

/**
 * Class DataSetContextNotFoundException
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataSetContextNotFoundException extends \InvalidArgumentException
{
    public function __construct($column)
    {
        parent::__construct(sprintf('DataSet context "%s" not found', $column));
    }
}
