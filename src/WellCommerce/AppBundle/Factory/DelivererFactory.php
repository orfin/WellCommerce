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

namespace WellCommerce\AppBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\AppBundle\Entity\Deliverer;
use WellCommerce\CoreBundle\Factory\AbstractFactory;

/**
 * Class DelivererFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DelivererFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\AppBundle\Entity\DelivererInterface
     */
    public function create()
    {
        $deliverer = new Deliverer();
        $deliverer->setProducers(new ArrayCollection());

        return $deliverer;
    }
}
