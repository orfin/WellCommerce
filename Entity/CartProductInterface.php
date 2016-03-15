<?php

namespace WellCommerce\Bundle\CartBundle\Entity;

use WellCommerce\Bundle\AppBundle\Entity\DiscountablePrice;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAwareInterface;
use WellCommerce\Bundle\ProductBundle\Entity\VariantAwareInterface;

/**
 * Interface CartProductInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartProductInterface extends
    EntityInterface,
    VariantAwareInterface,
    TimestampableInterface,
    ProductAwareInterface,
    CartAwareInterface
{
    /**
     * @return int
     */
    public function getQuantity() : int;

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity);

    /**
     * @param int $increase
     */
    public function increaseQuantity(int $increase);

    /**
     * @param int $decrease
     */
    public function decreaseQuantity(int $decrease);

    /**
     * @return DiscountablePrice
     */
    public function getSellPrice() : DiscountablePrice;

    /**
     * @return float
     */
    public function getWeight() : float;

    /**
     * @return array
     */
    public function getOptions();

    /**
     * @param $options
     */
    public function setOptions($options);
}
