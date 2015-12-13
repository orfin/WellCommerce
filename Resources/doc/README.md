Overriding existing entity

1. add an override to config

well_commerce_cart:
    services:
        cart_product:
            orm_configuration:
                mapping: "@WellCommerceCartBundle/Resources/config/doctrine/CartProductTest.orm.yml"
                entity: WellCommerce\Bundle\CartBundle\Entity\CartProductTest

2. add resolve target entity

doctrine:
    orm:
        resolve_target_entities:
            WellCommerce\Bundle\CartBundle\Entity\CartProductInterface: WellCommerce\Bundle\CartBundle\Entity\CartProductTest

3. add mapping file

CartProductTest.orm.yml

WellCommerce\Bundle\CartBundle\Entity\CartProductTest:
    type: entity
    table: cart_product
    repositoryClass: WellCommerce\Bundle\CartBundle\Repository\CartProductRepository
    id:
        id:
            type: integer
            generator:
                strategy: AUTO
    fields:
        quantity:
            type: integer
            nullable: false
        subscription:
            type: integer
            nullable: true
    manyToOne:
        cart:
            targetEntity: WellCommerce\Bundle\CartBundle\Entity\Cart
            fetch: LAZY
            inversedBy: products
            joinColumns:
                cart_id:
                    referencedColumnName: id
                    onDelete: CASCADE
        product:
            targetEntity: WellCommerce\Bundle\ProductBundle\Entity\Product
            fetch: LAZY
            joinColumns:
                product_id:
                    referencedColumnName: id
                    onDelete: CASCADE
        attribute:
            targetEntity: WellCommerce\Bundle\ProductBundle\Entity\ProductAttribute
            fetch: LAZY
            joinColumns:
                attribute_id:
                    referencedColumnName: id
                    onDelete: CASCADE

4. add an entity class

<?php

namespace WellCommerce\Bundle\CartBundle\Entity;

/**
 * Class CartProduct
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartProductTest extends CartProduct
{
    protected $subscription;

    /**
     * @return mixed
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * @param mixed $subscription
     */
    public function setSubscription($subscription)
    {
        $this->subscription = $subscription;
    }


}

