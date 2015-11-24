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

namespace WellCommerce\AppBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\AppBundle\Entity\Page;
use WellCommerce\CoreBundle\Factory\AbstractFactory;

/**
 * Class PageFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PageFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\AppBundle\Entity\PageInterface
     */
    public function create()
    {
        $page = new Page();
        $page->setHierarchy(0);
        $page->setCreatedAt(new \DateTime());
        $page->setClientGroups(new ArrayCollection());
        $page->setShops(new ArrayCollection());
        $page->setParent(null);
        $page->setPublish(true);
        $page->setRedirectType(1);

        return $page;
    }
}
