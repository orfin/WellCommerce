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

namespace WellCommerce\Bundle\AppBundle\Entity;

use WellCommerce\Bundle\AppBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\AppBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\AppBundle\Entity\TranslatableInterface;

/**
 * Interface DictionaryInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DictionaryInterface extends TranslatableInterface, TimestampableInterface, BlameableInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getIdentifier();

    /**
     * @param string $identifier
     */
    public function setIdentifier($identifier);
}
