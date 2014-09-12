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

namespace WellCommerce\Bundle\PaymentBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use WellCommerce\Bundle\CoreBundle\Entity\Behaviours\EnableableTrait;
use WellCommerce\Bundle\CoreBundle\Entity\Behaviours\HierarchyTrait;
use WellCommerce\Bundle\ShopBundle\Entity\Shop;

/**
 * Class PaymentMethod
 *
 * @package WellCommerce\Bundle\PaymentBundle\Entity
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @ORM\Table(name="payment_method")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\PaymentBundle\Repository\PaymentMethodRepository")
 */
class PaymentMethod
{
    use ORMBehaviors\Translatable\Translatable;
    use ORMBehaviors\Timestampable\Timestampable;
    use ORMBehaviors\Blameable\Blameable;
    use EnableableTrait;
    use HierarchyTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="WellCommerce\Bundle\ShopBundle\Entity\Shop", inversedBy="paymentMethods")
     * @ORM\JoinTable(name="shop_payment_method",
     *      joinColumns={@ORM\JoinColumn(name="payment_method_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="shop_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    private $shops;

    /**
     * @var string
     *
     * @ORM\Column(name="processor", type="string", length=64)
     */
    private $processor;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->shops = new ArrayCollection();
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
     * Sets shops for payment method
     *
     * @param $shops
     */
    public function setShops($shops)
    {
        $this->shops = $shops;
    }

    /**
     * Get shops for payment method
     *
     * @return mixed
     */
    public function getShops()
    {
        return $this->shops;
    }

    /**
     * Adds payment method to shop
     *
     * @param Shop $shop
     */
    public function addShop(Shop $shop)
    {
        $this->shops[] = $shop;
    }

    public function removeShop(Shop $shop)
    {
        $this->shops->removeElement($shop);
    }

    /**
     * Returns payment method processor
     *
     * @return string
     */
    public function getProcessor()
    {
        return $this->processor;
    }

    /**
     * Sets payment method processor
     *
     * @param $processor
     */
    public function setProcessor($processor)
    {
        $this->processor = $processor;
    }

}

