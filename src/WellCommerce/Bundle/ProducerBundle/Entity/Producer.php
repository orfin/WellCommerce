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

namespace WellCommerce\Bundle\ProducerBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\PhotoTrait;
use WellCommerce\Bundle\DelivererBundle\Entity\Deliverer;
use WellCommerce\Bundle\DelivererBundle\Entity\DelivererInterface;
use WellCommerce\Bundle\MultiStoreBundle\Entity\Shop;
use WellCommerce\Bundle\MultiStoreBundle\Entity\ShopCollectionAwareTrait;
use WellCommerce\Bundle\MultiStoreBundle\Entity\ShopInterface;

/**
 * Class Producer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Producer implements ProducerInterface
{
    use Translatable, Timestampable, Blameable, PhotoTrait, ShopCollectionAwareTrait;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var Collection|\WellCommerce\Bundle\DelivererBundle\Entity\DelivererInterface[]
     */
    protected $deliverers;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Collection|\WellCommerce\Bundle\DelivererBundle\Entity\DelivererInterface[]
     */
    public function getDeliverers()
    {
        return $this->deliverers;
    }

    /**
     * @param Collection $collection
     */
    public function setDeliverers(Collection $collection)
    {
        $this->deliverers = $collection;
    }

    /**
     * @param DelivererInterface $deliverer
     */
    public function addDeliverer(DelivererInterface $deliverer)
    {
        $this->deliverers = $deliverer;
    }
}
