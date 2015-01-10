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
namespace WellCommerce\Bundle\RoutingBundle\Repository;

use WellCommerce\Bundle\CoreBundle\Repository\AbstractEntityRepository;
use WellCommerce\Bundle\RoutingBundle\Entity\RouteInterface;
use WellCommerce\Bundle\RoutingBundle\Helper\Sluggable;

/**
 * Class RouteRepository
 *
 * @package WellCommerce\Bundle\RoutingBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RouteRepository extends AbstractEntityRepository implements RouteRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataGridQueryBuilder()
    {
        return parent::getQueryBuilder()->groupBy('route.id');
    }

    /**
     * {@inheritdoc}
     */
    public function generateSlug($name, $id, $locale, $values, $iteration = 0)
    {
        $slug = Sluggable::makeSlug($name);

        // check generated slug against other values
        $existsInValues = in_array($slug, (array)$values);

        // if slug is the same as other values, try to add locale part
        if ($existsInValues) {
            $slug = sprintf('%s-%s', $slug, $locale);
        }

        // check if slug has a resource
        $route = $this->findRouteByPath($slug);

        if (null !== $route) {
            // if passed identifier and locale are same as in route, assume we can change slug directly
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
     * @param $slug
     *
     * @return null|\WellCommerce\Bundle\RoutingBundle\Entity\RouteInterface
     */
    protected function findRouteByPath($slug)
    {
        return $this->findOneBy(['path' => $slug]);
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
        return ($this->getRouteIdentifier($route)->getId() == $id && $route->getLocale() == $locale);
    }

    /**
     * @param RouteInterface $route
     *
     * @return object
     */
    protected function getRouteIdentifier(RouteInterface $route)
    {
        return $route->getIdentifier();
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
