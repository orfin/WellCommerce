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

namespace WellCommerce\Bundle\DashboardBundle\Behat;

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Symfony\Component\HttpKernel\KernelInterface;
use Behat\MinkExtension\Context\RawMinkContext;
use WellCommerce\Bundle\CoreBundle\Behat\CoreContext;

/**
 * Class DashboardContext
 *
 * @package WellCommerce\Bundle\DashboardBundle\Behat
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