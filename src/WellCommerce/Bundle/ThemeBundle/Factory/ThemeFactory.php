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

use WellCommerce\Bundle\DoctrineBundle\Factory\EntityFactory;
use WellCommerce\Bundle\ThemeBundle\Entity\ThemeInterface;

/**
 * Class ThemeFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ThemeFactory extends EntityFactory
{
    public function create() : ThemeInterface
    {
        /** @var  $theme ThemeInterface */
        $theme = $this->init();
        $theme->setCss($this->createEmptyCollection());
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
