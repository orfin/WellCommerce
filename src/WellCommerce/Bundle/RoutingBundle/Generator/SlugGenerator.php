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

namespace WellCommerce\Bundle\RoutingBundle\Generator;

use WellCommerce\Bundle\CoreBundle\Helper\Sluggable;
use WellCommerce\Bundle\CoreBundle\Manager\ManagerInterface;
use WellCommerce\Bundle\RoutingBundle\Entity\RouteInterface;

/**
 * Class SlugGenerator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class SlugGenerator implements SlugGeneratorInterface
{
    /**
     * @var ManagerInterface
     */
    private $manager;
    
    /**
     * SlugGenerator constructor.
     *
     * @param ManagerInterface $manager
     */
    public function __construct(ManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function generate(string $name, $id, string $locale, $values, int $iteration = 0) : string
    {
        $slug           = Sluggable::makeSlug($name);
        $existsInValues = in_array($slug, (array)$values);
        
        // if slug is the same as other values, try to add locale part
        if ($existsInValues) {
            $slug = sprintf('%s-%s', $slug, $locale);
        }
        
        $route = $this->manager->getRepository()->findOneBy(['path' => $slug]);
        
        if (null !== $route) {
            // if passed identifier and locale are same as in route, assume we can change the slug directly
            if ($this->hasRouteSameLocaleAndId($route, $locale, $id)) {
                return $slug;
            } else {
                $iteration++;
                $slug = $this->makeSlugIterated($slug, $iteration);
                
                return $this->generate($slug, $id, $locale, $values, $iteration);
            }
        }
        
        return $slug;
    }
    
    /**
     * Checks passed identifier and locale against those in route
     *
     * @param RouteInterface $route
     * @param                $locale
     * @param                $id
     *
     * @return bool
     */
    private function hasRouteSameLocaleAndId(RouteInterface $route, string $locale, $id) : bool
    {
        return ($route->getIdentifier()->getId() === $id && $route->getLocale() === $locale);
    }
    
    /**
     * Makes original slug iterated
     *
     * @param string $slug
     * @param int    $iteration
     *
     * @return string
     */
    private function makeSlugIterated($slug, $iteration)
    {
        return sprintf('%s%s%s', $slug, Sluggable::SLUG_DELIMITER, $iteration);
    }
}
