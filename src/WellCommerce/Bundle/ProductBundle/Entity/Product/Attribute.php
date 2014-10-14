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

namespace WellCommerce\Bundle\ProductBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\CoreBundle\Entity\Behaviours\HierarchyTrait;
use WellCommerce\Bundle\CoreBundle\Entity\Behaviours\PhotoTrait;

/**
 * ProductPhoto
 *
 * @ORM\Table(name="product_attribute")
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\ProductBundle\Repository\ProductAttributeRepository")
 */
class Attribute
{
    use Timestampable;
    use HierarchyTrait;
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
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\ProductBundle\Entity\Product", inversedBy="attributes")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $product;

    /**
     * @ORM\ManyToMany(targetEntity="WellCommerce\Bundle\AttributeBundle\Entity\AttributeValue", inversedBy="productAttributeValues")
     * @ORM\JoinTable(name="product_attribute_value",
     *      joinColumns={@ORM\JoinColumn(name="product_attribute_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="attribute_value_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    private $attributeValues;

    /**
     * @var string
     *
     * @ORM\Column(name="sell_price", type="decimal", precision=15, scale=4)
     */
    private $sellPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="weight", type="decimal", precision=15, scale=4)
     */
    private $weight;

    /**
     * @var string
     *
     * @ORM\Column(name="symbol", type="string")
     */
    private $symbol;

    /**
     * @var string
     *
     * @ORM\Column(name="stock", type="decimal", precision=15, scale=4)
     */
    private $stock;

    /**
     * @var string
     *
     * @ORM\Column(name="modifier_type", type="string")
     */
    private $modifierType;

    /**
     * @var string
     *
     * @ORM\Column(name="modifier_value", type="decimal", precision=15, scale=4)
     */
    private $modifierValue;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\AvailabilityBundle\Entity\Availability")
     * @ORM\JoinColumn(name="availability_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $availability;

    /**
     * @param mixed $attribute
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * @return mixed
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @param mixed $attributeValues
     */
    public function setAttributeValues($attributeValues)
    {
        $this->attributeValues = $attributeValues;
    }

    /**
     * @return mixed
     */
    public function getAttributeValues()
    {
        return $this->attributeValues;
    }

    /**
     * @param mixed $availability
     */
    public function setAvailability($availability)
    {
        $this->availability = $availability;
    }

    /**
     * @return mixed
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * @param string $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * @return string
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param string $symbol
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;
    }

    /**
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * @param string $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    /**
     * @return string
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param string $sellPrice
     */
    public function setSellPrice($sellPrice)
    {
        $this->sellPrice = $sellPrice;
    }

    /**
     * @return string
     */
    public function getSellPrice()
    {
        return $this->sellPrice;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param string $modifierValue
     */
    public function setModifierValue($modifierValue)
    {
        $this->modifierValue = $modifierValue;
    }

    /**
     * @return string
     */
    public function getModifierValue()
    {
        return $this->modifierValue;
    }

    /**
     * @param string $modifierType
     */
    public function setModifierType($modifierType)
    {
        $this->modifierType = $modifierType;
    }

    /**
     * @return string
     */
    public function getModifierType()
    {
        return $this->modifierType;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

