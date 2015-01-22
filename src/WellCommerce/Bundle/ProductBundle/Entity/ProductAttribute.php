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

namespace WellCommerce\Bundle\ProductBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\AvailabilityBundle\Entity\Availability;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\HierarchyTrait;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\PhotoTrait;

/**
 * ProductAttribute
 *
 * @ORM\Table(name="product_attribute")
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\ProductBundle\Repository\ProductAttributeRepository")
 */
class ProductAttribute
{
    use Timestampable;
    use HierarchyTrait;
    use PhotoTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\ProductBundle\Entity\Product", inversedBy="attributes")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $product;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="WellCommerce\Bundle\AttributeBundle\Entity\AttributeValue", inversedBy="productAttributeValues")
     * @ORM\JoinTable(name="product_attribute_value",
     *      joinColumns={@ORM\JoinColumn(name="product_attribute_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="attribute_value_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    private $attributeValues;

    /**
     * @var float
     *
     * @ORM\Column(name="sell_price", type="decimal", precision=15, scale=4)
     */
    private $sellPrice;

    /**
     * @var float
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
     * @var float
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
     * @var float
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
     * @return ArrayCollection
     */
    public function getAttributeValues()
    {
        return $this->attributeValues;
    }

    /**
     * @param ArrayCollection $attributeValues
     */
    public function setAttributeValues(ArrayCollection $attributeValues)
    {
        $this->attributeValues = $attributeValues;
    }

    /**
     * @return Availability|null
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * @param Availability|null $availability
     */
    public function setAvailability(Availability $availability = null)
    {
        $this->availability = $availability;
    }

    /**
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * @param string $symbol
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;
    }

    /**
     * @return float
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param float $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    /**
     * @return float
     */
    public function getSellPrice()
    {
        return $this->sellPrice;
    }

    /**
     * @param float $sellPrice
     */
    public function setSellPrice($sellPrice)
    {
        $this->sellPrice = $sellPrice;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @return string
     */
    public function getModifierValue()
    {
        return $this->modifierValue;
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
    public function getModifierType()
    {
        return $this->modifierType;
    }

    /**
     * @param string $modifierType
     */
    public function setModifierType($modifierType)
    {
        $this->modifierType = $modifierType;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
