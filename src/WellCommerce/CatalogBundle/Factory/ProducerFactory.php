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

namespace WellCommerce\CatalogBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\CatalogBundle\Entity\Producer;
use WellCommerce\AppBundle\Factory\AbstractFactory;

/**
 * Class ProducerFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\CatalogBundle\Entity\ProducerInterface
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
