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
use WellCommerce\Bundle\PageBundle\Entity\PageInterface;

/**
 * Class PageFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PageFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = PageInterface::class;
    
    /**
     * @return PageInterface
     */
    public function create() : PageInterface
    {
        /** @var  $page PageInterface */
        $page = $this->init();
        $page->setHierarchy(0);
        $page->setCreatedAt(new \DateTime());
        $page->setClientGroups($this->getDefaultClientGroups());
        $page->setShops($this->getDefaultShops());
        $page->setParent(null);
        $page->setPublish(true);
        $page->setRedirectType(1);
        $page->setSection('');
        
        return $page;
    }
    
    private function getDefaultClientGroups()
    {
        return $this->get('client_group.repository')->matching(new Criteria());
    }
}
