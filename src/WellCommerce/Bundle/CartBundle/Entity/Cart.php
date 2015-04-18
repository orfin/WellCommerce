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
namespace WellCommerce\Bundle\CartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\Timestampable\TimestampableTrait;

/**
 * Class Cart
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @ORM\Table(name="cart")
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\CartBundle\Repository\CartRepository")
 */
class Cart
{
    use TimestampableTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="WellCommerce\Bundle\CartBundle\Entity\CartProduct", mappedBy="cart", cascade={"persist"})
     */
    private $products;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param ArrayCollection $products
     */
    public function setProducts(ArrayCollection $products)
    {
        $this->products = $products;
    }

    /**
     * @param CartProduct $cartProduct
     */
    public function addProduct(CartProduct $cartProduct)
    {
        $this->products->add($cartProduct);
    }
}
