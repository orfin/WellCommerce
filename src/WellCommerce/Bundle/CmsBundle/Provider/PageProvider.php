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

class PageProvider implements ProviderInterface
{
    /**
     * @var Page
     */
    protected $resource;

    /**
     * @return mixed
     */
    public function getCurrentResource()
    {
        return $this->resource;
    }

    /**
     * @param mixed $resource
     */
    public function setCurrentResource($resource)
    {
        $this->setCurrentPage($resource);
    }

    /**
     * @param Page $page
     */
    protected function setCurrentPage(Page $page)
    {
        $this->resource = $page;
    }
}
