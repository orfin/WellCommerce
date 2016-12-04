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
    public function getPath(): string;
    
    public function setPath(string $path);
    
    public function getLocale(): string;
    
    public function setLocale(string $locale);
    
    public function setIdentifier($identifier);
    
    public function getIdentifier();
    
    public function getType(): string;
}
