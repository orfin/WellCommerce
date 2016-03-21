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
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TranslatableInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;

/**
 * Interface LayoutBoxInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface LayoutBoxInterface extends EntityInterface, TimestampableInterface, TranslatableInterface, BlameableInterface
{
    /**
     * @return string
     */
    public function getBoxType() : string;

    /**
     * @param string $boxType
     */
    public function setBoxType(string $boxType);

    /**
     * @return array
     */
    public function getSettings() : array;

    /**
     * @param array $settings
     */
    public function setSettings(array $settings);

    /**
     * @return string
     */
    public function getIdentifier() : string;

    /**
     * @param string $identifier
     */
    public function setIdentifier(string $identifier);
}
