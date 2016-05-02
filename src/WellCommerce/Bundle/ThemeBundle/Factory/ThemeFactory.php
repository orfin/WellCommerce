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

namespace WellCommerce\Bundle\ThemeBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\ThemeBundle\Entity\ThemeInterface;

/**
 * Class ThemeFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ThemeFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = ThemeInterface::class;
    
    /**
     * @return ThemeInterface
     */
    public function create() : ThemeInterface
    {
        /** @var  $theme ThemeInterface */
        $theme = $this->init();
        $theme->setCss(new ArrayCollection());
        $theme->setName('');
        $theme->setFolder($this->getDefaultFolder());
        
        return $theme;
    }
    
    private function getDefaultFolder() : string
    {
        $themeFolders = $this->get('theme.locator')->getThemeFolders();
        
        return reset($themeFolders);
    }
}
