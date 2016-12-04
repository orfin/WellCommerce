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

namespace WellCommerce\Bundle\LayoutBundle\Entity;

use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TranslatableInterface;

/**
 * Interface LayoutBoxInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface LayoutBoxInterface extends EntityInterface, TimestampableInterface, TranslatableInterface, BlameableInterface
{
    public function getBoxType() : string;
    
    public function setBoxType(string $boxType);
    
    public function getSettings() : array;

    public function setSettings(array $settings);

    public function getIdentifier() : string;

    public function setIdentifier(string $identifier);
}
