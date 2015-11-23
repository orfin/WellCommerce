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

namespace WellCommerce\AppBundle\Context;

/**
 * Interface ReportContextInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ReportContextInterface
{
    /**
     * @return array
     */
    public function getLabels();

    /**
     * @return array
     */
    public function getValues();
}
