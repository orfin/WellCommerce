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

namespace WellCommerce\CmsBundle\Entity;

use WellCommerce\AppBundle\Entity\BlameableInterface;
use WellCommerce\AppBundle\Entity\TimestampableInterface;
use WellCommerce\AppBundle\Entity\TranslatableInterface;

/**
 * Interface ContactInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ContactInterface extends TimestampableInterface, TranslatableInterface, BlameableInterface
{
    /**
     * @return integer
     */
    public function getId();
}
