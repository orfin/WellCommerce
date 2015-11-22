<?php

namespace WellCommerce\SalesBundle\Entity;

use WellCommerce\CatalogBundle\Entity\ProductAttributeInterface;
use WellCommerce\CatalogBundle\Entity\ProductAwareInterface;
use WellCommerce\AppBundle\Entity\TimestampableInterface;

/**
 * Interface CartProductInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartProductInterface extends TimestampableInterface, ProductAwareInterface, CartAwareInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return null|ProductAttributeInterface
     */
    public function getAttribute();

    /**
     * @param null|ProductAttributeInterface $attribute
     */
    public function setAttribute(ProductAttributeInterface $attribute = null);

    /**
     * @return float
     */
    public function getQuantity();

    /**
     * @param float $quantity
     */
    public function setQuantity($quantity);

    /**
     * @param $increase
     */
    public function increaseQuantity($increase);

    /**
     * @param $decrease
     */
    public function decreaseQuantity($decrease);

    /**
     * @return \WellCommerce\AppBundle\Entity\DiscountablePrice
     */
    public function getSellPrice();

    /**
     * @return float
     */
    public function getWeight();
}
