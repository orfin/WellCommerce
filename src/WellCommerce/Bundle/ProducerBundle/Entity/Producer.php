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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use WellCommerce\Bundle\CoreBundle\Entity\Behaviours\PhotoTrait;
use WellCommerce\Bundle\DelivererBundle\Entity\Deliverer;
use WellCommerce\Bundle\ShopBundle\Entity\Shop;

/**
 * Class Locale
 *
 * @package WellCommerce\Bundle\ProducerBundle\Entity
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @ORM\Table(name="producer")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\ProducerBundle\Repository\ProducerRepository")
 */
class Producer
{
    use ORMBehaviors\Translatable\Translatable;
    use ORMBehaviors\Timestampable\Timestampable;
    use ORMBehaviors\Blameable\Blameable;
    use PhotoTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="WellCommerce\Bundle\ShopBundle\Entity\Shop", inversedBy="producers")
     * @ORM\JoinTable(name="shop_producer",
     *      joinColumns={@ORM\JoinColumn(name="producer_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="shop_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    private $shops;

    /**
     * @ORM\ManyToMany(targetEntity="WellCommerce\Bundle\DelivererBundle\Entity\Deliverer", inversedBy="producers")
     * @ORM\JoinTable(name="producer_deliverer",
     *      joinColumns={@ORM\JoinColumn(name="producer_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="deliverer_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    private $deliverers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->shops      = new ArrayCollection();
        $this->deliverers = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get shops for category
     *
     * @return mixed
     */
    public function getShops()
    {
        return $this->shops;
    }

    /**
     * Sets shops for category
     *
     * @param $shops
     */
    public function setShops($shops)
    {
        $this->shops = $shops;
    }

    public function addShop(Shop $shop)
    {
        $this->shops[] = $shop;
    }

    /**
     * Returns all available deliverers for producer
     *
     * @return ArrayCollection
     */
    public function getDeliverers()
    {
        return $this->deliverers;
    }

    public function setDeliverers(ArrayCollection $collection)
    {
        $this->deliverers = $collection;
    }

    /**
     * Adds new deliverer to producer
     *
     * @param Deliverer $deliverer
     */
    public function addDeliverer(Deliverer $deliverer)
    {
        $this->deliverers = $deliverer;
    }
}

