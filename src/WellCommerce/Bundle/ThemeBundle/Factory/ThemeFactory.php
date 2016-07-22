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

use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\ThemeBundle\Entity\Theme;
use WellCommerce\Bundle\ThemeBundle\Entity\ThemeInterface;

/**
 * Class ThemeFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ThemeFactory extends AbstractEntityFactory
{
    public function create() : ThemeInterface
    {
        $theme = new Theme();
        $theme->setCss($this->createEmptyCollection());
        $theme->setName('');
        $theme->setFolder('');
        
        return $theme;
    }
}
