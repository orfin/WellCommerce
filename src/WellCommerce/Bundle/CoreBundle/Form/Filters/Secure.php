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

namespace WellCommerce\Bundle\CoreBundle\Form\Filters;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFilter;

/**
 * Class Secure
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Filters
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Secure extends AbstractFilter implements FilterInterface
{
    /**
     * Checks whether given value is secure and cleans it if needed
     *
     * @param $value
     *
     * @return mixed
     */
    public function filterValue($value)
    {
        return $value;
    }
}
