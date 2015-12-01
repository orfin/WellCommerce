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

use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;

/**
 * Class PaymentInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PaymentInterface extends TimestampableInterface, OrderAwareInterface
{
    /**
     * @return int
     */
    public function getId();
}
