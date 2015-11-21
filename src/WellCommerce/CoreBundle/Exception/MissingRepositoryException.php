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

namespace WellCommerce\CoreBundle\Exception;

/**
 * Class MissingRepositoryException
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MissingRepositoryException extends \LogicException
{
    /**
     * @param string $className
     */
    public function __construct($className)
    {
        parent::__construct(sprintf('Repository service is missing in "%s"', $className));
    }
}
