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

namespace WellCommerce\Bundle\DelivererBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\DelivererBundle\Entity\DelivererInterface;

/**
 * Class DelivererFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DelivererFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = DelivererInterface::class;

    /**
     * @return DelivererInterface
     */
    public function create()
    {
        /** @var $deliverer DelivererInterface */
        $deliverer = $this->init();
        $deliverer->setProducers(new ArrayCollection());

        return $deliverer;
    }
}
