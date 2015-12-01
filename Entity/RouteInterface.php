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

namespace WellCommerce\Bundle\AppBundle\Entity;

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
     * @param string $locale
     */
    public function setLocale($locale);

    /**
     * @param object $identifier
     */
    public function setIdentifier($identifier);

    /**
     * @return object
     */
    public function getIdentifier();

    /**
     * @return string
     */
    public function getType();
}
