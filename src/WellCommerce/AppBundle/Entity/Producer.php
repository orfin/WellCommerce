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

namespace WellCommerce\AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use WellCommerce\AppBundle\Entity\ShopCollectionAwareTrait;
use WellCommerce\AppBundle\Doctrine\ORM\Behaviours\PhotoTrait;

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
     * @var Collection|\WellCommerce\AppBundle\Entity\ProductInterface[]
     */
    protected $products;

    /**
     * @var Collection|\WellCommerce\AppBundle\Entity\DelivererInterface[]
     */
    protected $deliverers;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * {@inheritdoc}
     */
    public function getDeliverers()
    {
        return $this->deliverers;
    }

    /**
     * {@inheritdoc}
     */
    public function setDeliverers(Collection $collection)
    {
        $this->deliverers = $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function addDeliverer(DelivererInterface $deliverer)
    {
        $this->deliverers = $deliverer;
    }
}
