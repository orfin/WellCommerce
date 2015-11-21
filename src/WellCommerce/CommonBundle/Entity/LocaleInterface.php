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

namespace WellCommerce\CommonBundle\Entity;

use WellCommerce\CoreBundle\Entity\BlameableInterface;
use WellCommerce\CoreBundle\Entity\TimestampableInterface;

/**
 * Interface LocaleInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface LocaleInterface extends TimestampableInterface, BlameableInterface, CurrencyAwareInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @return string
     */
    public function getCode();

    /**
     * @param string $code
     */
    public function setCode($code);
}
