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
use WellCommerce\Bundle\CoreBundle\Provider\AbstractProvider;

class PageProvider extends AbstractProvider implements PageProviderInterface
{
    /**
     * @var Page
     */
    protected $page;

    /**
     * {@inheritdoc}
     */
    public function getCurrentPage()
    {
        return $this->page;
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrentPage(Page $page)
    {
        $this->page = $page;
    }
}
