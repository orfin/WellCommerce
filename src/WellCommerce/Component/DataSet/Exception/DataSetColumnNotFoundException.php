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
 * Class DataSetColumnNotFoundException
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataSetColumnNotFoundException extends \InvalidArgumentException
{
    public function __construct($column)
    {
        parent::__construct(sprintf('DataSet column "%s" not found', $column));
    }
}
