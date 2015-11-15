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

namespace WellCommerce\Bundle\CatalogBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\CatalogBundle\Entity\Producer;

/**
 * Class ProducerFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\Bundle\CatalogBundle\Entity\ProducerInterface
     */
    public function create()
    {
        $producer = new Producer();
        $producer->setDeliverers(new ArrayCollection());
        $producer->setPhoto(null);
        $producer->setShops(new ArrayCollection());

        return $producer;
    }
}
