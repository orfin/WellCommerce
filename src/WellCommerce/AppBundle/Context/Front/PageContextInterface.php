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

namespace WellCommerce\AppBundle\Context\Front;

use WellCommerce\AppBundle\Entity\PageInterface;

/**
 * Interface PageContextInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PageContextInterface
{
    /**
     * @param PageInterface $page
     */
    public function setCurrentPage(PageInterface $page);

    /**
     * @return null|PageInterface
     */
    public function getCurrentPage();

    /**
     * @return bool
     */
    public function hasCurrentPage();
}
