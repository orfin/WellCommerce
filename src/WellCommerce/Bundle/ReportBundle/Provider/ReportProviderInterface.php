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

namespace WellCommerce\Bundle\ReportBundle\Provider;

use WellCommerce\Bundle\ReportBundle\Configuration\ReportConfiguration;

/**
 * Interface ReportProviderInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ReportProviderInterface
{
    /**
     * Returns a report
     *
     * @param ReportConfiguration $configuration
     *
     * @return \WellCommerce\Bundle\ReportBundle\Data\ReportRowCollection
     */
    public function getReport(ReportConfiguration $configuration);
}
