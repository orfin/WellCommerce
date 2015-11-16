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

namespace WellCommerce\Bundle\CmsBundle\Context\Front;

use WellCommerce\Bundle\CmsBundle\Entity\PageInterface;

/**
 * Class PageContext
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PageContext implements PageContextInterface
{
    /**
     * @var PageInterface
     */
    protected $currentPage;

    /**
     * {@inheritdoc}
     */
    public function setCurrentPage(PageInterface $page)
    {
        $this->currentPage = $page;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * {@inheritdoc}
     */
    public function hasCurrentPage()
    {
        return $this->currentPage instanceof PageInterface;
    }
}
