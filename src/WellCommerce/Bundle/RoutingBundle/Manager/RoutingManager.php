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

namespace WellCommerce\Bundle\RoutingBundle\Manager;

use WellCommerce\Bundle\CoreBundle\Helper\Sluggable;
use WellCommerce\Bundle\CoreBundle\Manager\AbstractManager;
use WellCommerce\Bundle\CoreBundle\Manager\Admin\AbstractAdminManager;
use WellCommerce\Bundle\RoutingBundle\Entity\RouteInterface;

/**
 * Class RoutingManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RoutingManager extends AbstractManager
{
    /**
     * Generates and validates uniqueness of slug
     *
     * @param string   $name   Passed value to generate slug
     * @param int|null $id     Entity id
     * @param string   $locale Field locale
     * @param array    $values Other sluggable field values
     * @param int      $iteration
     *
     * @return string
     */
    public function generateSlug($name, $id, $locale, $values, $iteration = 0)
    {
        $slug           = Sluggable::makeSlug($name);
        $existsInValues = in_array($slug, (array)$values);

        // if slug is the same as other values, try to add locale part
        if ($existsInValues) {
            $slug = sprintf('%s-%s', $slug, $locale);
        }

        $route = $this->getRepository()->findOneBy(['path' => $slug]);

        if (null !== $route) {
            // if passed identifier and locale are same as in route, assume we can change the slug directly
            if ($this->hasRouteSameLocaleAndId($route, $locale, $id)) {
                return $slug;
            } else {
                $iteration++;
                $slug = $this->makeSlugIterated($slug, $iteration);

                return $this->generateSlug($slug, $id, $locale, $values, $iteration);
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
    protected function hasRouteSameLocaleAndId(RouteInterface $route, $locale, $id)
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
    protected function makeSlugIterated($slug, $iteration)
    {
        return sprintf('%s%s%s', $slug, Sluggable::SLUG_DELIMITER, $iteration);
    }
}
