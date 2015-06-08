<?php

namespace WellCommerce\Bundle\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use WellCommerce\Bundle\CoreBundle\Entity\Meta;
use WellCommerce\Bundle\IntlBundle\ORM\LocaleAwareInterface;
use WellCommerce\Bundle\RoutingBundle\Entity\Behaviours\RoutableTrait;
use WellCommerce\Bundle\RoutingBundle\Entity\RoutableSubjectInterface;

/**
 * CategoryTranslation
 *
 * @ORM\Table("category_translation")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity
 */
class CategoryTranslation implements RoutableSubjectInterface, LocaleAwareInterface
{
    use Translation;
    use RoutableTrait;

    /**
     * @ORM\OneToOne(targetEntity="WellCommerce\Bundle\CategoryBundle\Entity\CategoryRoute", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="route_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    protected $route;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="short_description", type="text", nullable=true)
     */
    protected $shortDescription;

    /**
     * @ORM\Embedded(class = "WellCommerce\Bundle\CoreBundle\Entity\Meta", columnPrefix = "meta_")
     */
    protected $meta;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->meta = new Meta();
    }

    /**
     * Returns translation ID.
     *
     * @return integer The ID.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * @param $shortDescription
     *
     * @return $this
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param $description
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
     * @return CategoryRoute|\WellCommerce\Bundle\RoutingBundle\Entity\RouteInterface
     */
    public function getRouteEntity()
    {
        return new CategoryRoute();
    }
}
