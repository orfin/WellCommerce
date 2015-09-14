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

namespace WellCommerce\Bundle\UserBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\CoreBundle\Factory\FactoryInterface;
use WellCommerce\Bundle\UserBundle\Entity\User;

/**
 * Class UserFactoryInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface UserFactoryInterface extends FactoryInterface
{
    /**
     * @return \WellCommerce\Bundle\UserBundle\Entity\UserInterface
     */
    public function create();
}
