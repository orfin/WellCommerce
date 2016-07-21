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

namespace WellCommerce\Bundle\DictionaryBundle\Entity;

use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TranslatableInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;

/**
 * Interface DictionaryInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DictionaryInterface extends EntityInterface, TranslatableInterface, TimestampableInterface, BlameableInterface
{
    /**
     * @return string
     */
    public function getIdentifier() : string;

    /**
     * @param string $identifier
     */
    public function setIdentifier(string $identifier);
}
