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

namespace WellCommerce\Bundle\PageBundle\Factory;

use Doctrine\Common\Collections\Criteria;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\PageBundle\Entity\Page;
use WellCommerce\Bundle\PageBundle\Entity\PageInterface;

/**
 * Class PageFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PageFactory extends AbstractEntityFactory
{
    public function create() : PageInterface
    {
        $page = new Page();
        $page->setHierarchy(0);
        $page->setCreatedAt(new \DateTime());
        $page->setClientGroups($this->createEmptyCollection());
        $page->setShops($this->createEmptyCollection());
        $page->setParent(null);
        $page->setPublish(true);
        $page->setRedirectType(1);
        $page->setSection('');
        
        return $page;
    }
}
