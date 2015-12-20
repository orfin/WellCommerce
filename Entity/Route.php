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

/**
 * Class Route
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Route implements RouteInterface, RoutingDiscriminatorsAwareInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var object
     */
    protected $identifier;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return object
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param object $identifier
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
