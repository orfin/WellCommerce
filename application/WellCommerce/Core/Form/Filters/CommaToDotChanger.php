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

namespace WellCommerce\Core\Form\Filters;

use WellCommerce\Core\Form\Filter;

/**
 * Class CommaToDotChanger
 *
 * Replaces commas with dots. Required to normalize submitted decimals.
 *
 * @package WellCommerce\Core\Form\Filters
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CommaToDotChanger extends Filter implements FilterInterface
{

    public function filterValue($value)
    {
        return str_replace(',', '.', $value);
    }

}