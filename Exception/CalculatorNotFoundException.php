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

namespace WellCommerce\Bundle\AppBundle\Exception;

/**
 * Class CalculatorNotFoundException
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CalculatorNotFoundException extends \RuntimeException
{
    /**
     * @param string $calculator
     */
    public function __construct($calculator)
    {
        parent::__construct(sprintf('Calculator "%s" was not found', $calculator));
    }
}
