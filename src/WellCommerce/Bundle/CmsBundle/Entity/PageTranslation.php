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

namespace WellCommerce\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use WellCommerce\Bundle\CoreBundle\Entity\Meta;
use WellCommerce\Bundle\IntlBundle\ORM\LocaleAwareInterface;
use WellCommerce\Bundle\RoutingBundle\Entity\Behaviours\RoutableTrait;
use WellCommerce\Bundle\RoutingBundle\Entity\RoutableSubjectInterface;

/**
 * PageTranslation
 *
 * @ORM\Table(name="page_translation")
 * @ORM\Entity
 */
class PageTranslation implements RoutableSubjectInterface, LocaleAwareInterface
{
    use Translation;
    use RoutableTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    protected $content;

    /**
     * @ORM\OneToOne(targetEntity="WellCommerce\Bundle\CmsBundle\Entity\PageRoute", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="route_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    protected $route;

    /**
     * @ORM\Embedded(class = "WellCommerce\Bundle\CoreBundle\Entity\Meta", columnPrefix = "meta_")
     */
    protected $meta;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->meta = new Meta();
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return PageRoute|\WellCommerce\Bundle\RoutingBundle\Entity\RouteInterface
     */
    public function getRouteEntity()
    {
        return new PageRoute();
    }
}
