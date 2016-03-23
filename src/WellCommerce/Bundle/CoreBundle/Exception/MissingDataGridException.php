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

namespace WellCommerce\Bundle\CoreBundle\Exception;

/**
 * Class MissingDataGridException
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MissingDataGridException extends \LogicException
{
    /**
     * @param string $className
     */
    public function __construct($className)
    {
        parent::__construct(sprintf('DataGrid service is missing in "%s"', $className));
    }
}
