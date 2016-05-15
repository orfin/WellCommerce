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

namespace WellCommerce\Bundle\PageBundle\Storage;

use WellCommerce\Bundle\PageBundle\Entity\PageInterface;

/**
 * Interface PageStorageInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PageStorageInterface
{
    /**
     * @param PageInterface $page
     */
    public function setCurrentPage(PageInterface $page);

    /**
     * @return PageInterface
     */
    public function getCurrentPage() : PageInterface;

    /**
     * @return bool
     */
    public function hasCurrentPage() : bool;
}
