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

use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;

/**
 * Class Route
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Route extends AbstractEntity implements RouteInterface, RoutingDiscriminatorsAwareInterface
{
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
     * @return string
     */
    public function getPath() : string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getLocale() : string
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale(string $locale)
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

    public function getType() : string
    {
        return 'route';
    }
}
