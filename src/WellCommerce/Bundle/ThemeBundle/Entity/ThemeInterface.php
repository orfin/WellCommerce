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

namespace WellCommerce\Bundle\ThemeBundle\Entity;

use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;

/**
 * Interface ThemeInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ThemeInterface extends EntityInterface, TimestampableInterface, BlameableInterface
{
    /**
     * @return string
     */
    public function getName() : string;
    
    /**
     * @param string $name
     */
    public function setName(string $name);
    
    /**
     * @return string
     */
    public function getFolder() : string;
    
    /**
     * @param string $folder
     */
    public function setFolder(string $folder);
}
