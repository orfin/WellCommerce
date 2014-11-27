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

namespace WellCommerce\Bundle\AdminBundle\Behat;

use WellCommerce\Bundle\CoreBundle\Behat\CoreContext;

/**
 * Class DashboardContext
 *
 * @package WellCommerce\Bundle\AdminBundle\Behat
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DashboardContext extends CoreContext
{
    /**
     * @Given I am on the dashboard page
     */
    public function iAmOnTheDashboardPage()
    {
        $this->getSession()->visit($this->generateUrl('admin.dashboard.index'));
    }
}