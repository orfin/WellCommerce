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

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Sluggable\Sluggable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use WellCommerce\Bundle\CoreBundle\Entity\Behaviours\HierarchyTrait;
use WellCommerce\Bundle\CoreBundle\Entity\Behaviours\MetaDataTrait;
use WellCommerce\Bundle\MediaBundle\Entity\Media;

/**
 * ProductPhoto
 *
 * @ORM\Table(name="product_attribute")
 * @ORM\Entity
 */
class ProductAttribute
{
    use Timestampable;
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
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\AttributeBundle\Entity\Attribute", inversedBy="products")
     * @ORM\JoinColumn(name="attribute_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $attribute;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\ProductBundle\Entity\Product", inversedBy="attributes")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $product;

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
     * @ORM\Column(name="stock", type="decimal", precision=15, scale=4)
     */
    private $stock;

    /**
     * @var string
     *
     * @ORM\Column(name="modifier_type", type="string")
     */
    private $modifierType;
}

