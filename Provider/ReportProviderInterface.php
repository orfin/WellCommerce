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

namespace WellCommerce\Bundle\AppBundle\Provider;

use WellCommerce\Bundle\AppBundle\Configuration\ReportConfiguration;

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
     * @return \WellCommerce\Bundle\AppBundle\Data\ReportRowCollection
     */
    public function getReport(ReportConfiguration $configuration);
}
