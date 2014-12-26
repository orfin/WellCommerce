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
 * Interface RouteInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface RouteInterface
{

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return mixed
     */
    public function getPath();

    /**
     * @param mixed $path
     */
    public function setPath($path);

    /**
     * @return mixed
     */
    public function getLocale();

    /**
     * @param mixed $locale
     */
    public function setLocale($locale);

    public function setIdentifier($identifier);

    public function getIdentifier();

    public function getType();
} 