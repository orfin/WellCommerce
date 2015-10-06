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

namespace WellCommerce\Bundle\ReportBundle\Data;

use WellCommerce\Common\Collections\ArrayCollection;

/**
 * Class ReportRowCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ReportRowCollection extends ArrayCollection
{
    /**
     * @param ReportRow $reportRow
     */
    public function add(ReportRow $reportRow)
    {
        $this->items[] = $reportRow;
    }

    /**
     * @return ReportRow[]
     */
    public function all()
    {
        return $this->items;
    }
}
