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
use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use WellCommerce\Bundle\CoreBundle\Entity\Meta;
use WellCommerce\Bundle\IntlBundle\ORM\LocaleAwareInterface;
use WellCommerce\Bundle\RoutingBundle\Entity\Behaviours\RoutableTrait;
use WellCommerce\Bundle\RoutingBundle\Entity\RoutableSubjectInterface;

/**
 * ProductTranslation
 *
 * @ORM\Table(name="product_translation")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity
 */
class ProductTranslation implements LocaleAwareInterface, RoutableSubjectInterface
{
    use Translation;
    use RoutableTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="short_description", type="text", nullable=true)
     */
    private $shortDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Embedded(class = "WellCommerce\Bundle\CoreBundle\Entity\Meta", columnPrefix = "meta_")
     */
    private $meta;

    /**
     * @ORM\OneToOne(targetEntity="WellCommerce\Bundle\ProductBundle\Entity\ProductRoute", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="route_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    protected $route;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->meta = new Meta();
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return ProductTranslation
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get shortDescription
     *
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * Set shortDescription
     *
     * @param string $shortDescription
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return Meta
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @param Meta $meta
     */
    public function setMeta(Meta $meta)
    {
        $this->meta = $meta;
    }

    /**
     * @return ProductRoute|\WellCommerce\Bundle\RoutingBundle\Entity\RouteInterface
     */
    public function getRouteEntity()
    {
        return new ProductRoute();
    }
}
