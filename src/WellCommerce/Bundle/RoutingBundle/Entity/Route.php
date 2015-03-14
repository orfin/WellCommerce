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

namespace WellCommerce\Bundle\RoutingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\RoutingBundle\Repository\RouteRepository")
 * @ORM\Table(name="route")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *      "route"      = "WellCommerce\Bundle\RoutingBundle\Entity\Route",
 *      "product"    = "WellCommerce\Bundle\ProductBundle\Entity\ProductRoute",
 *      "producer"   = "WellCommerce\Bundle\ProducerBundle\Entity\ProducerRoute",
 *      "category"   = "WellCommerce\Bundle\CategoryBundle\Entity\CategoryRoute",
 *      "page"       = "WellCommerce\Bundle\CmsBundle\Entity\PageRoute",
 * })
 */
class Route implements RouteInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="path", type="string")
     */
    private $path;

    /**
     * @ORM\Column(name="locale", type="string", length=255, nullable=false)
     */
    protected $locale;

    protected $identifier;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param mixed $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param mixed $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    public function getType()
    {
        return 'route';
    }
}
