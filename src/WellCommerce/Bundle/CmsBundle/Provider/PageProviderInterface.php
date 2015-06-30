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

namespace WellCommerce\Bundle\CmsBundle\Provider;

use WellCommerce\Bundle\CmsBundle\Entity\Page;
use WellCommerce\Bundle\CoreBundle\Provider\ProviderInterface;

/**
 * Interface PageProviderInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PageProviderInterface extends ProviderInterface
{
    /**
     * Sets currently viewed cms page
     *
     * @param Page $page
     */
    public function setCurrentPage(Page $page);

    /**
     * Returns the currently viewed cms page
     *
     * @return Page
     */
    public function getCurrentPage();
}
