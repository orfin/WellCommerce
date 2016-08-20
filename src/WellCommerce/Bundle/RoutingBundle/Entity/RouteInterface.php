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

use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;

/**
 * Interface RouteInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface RouteInterface extends EntityInterface
{
    /**
     * @return string
     */
    public function getPath() : string;

    /**
     * @param string $path
     */
    public function setPath(string $path);

    /**
     * @return string
     */
    public function getLocale() : string;

    /**
     * @param string $locale
     */
    public function setLocale(string $locale);

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
    public function getType() : string;
}
