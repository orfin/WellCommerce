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

namespace WellCommerce\Bundle\RoutingBundle\Entity\Behaviours;

use WellCommerce\Bundle\RoutingBundle\Entity\Route;

/**
 * Class RoutableTrait
 *
 * @package WellCommerce\Bundle\RoutingBundle\Entity\Behaviours
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait RoutableTrait
{
    /**
     * @ORM\OneToOne(targetEntity="WellCommerce\Bundle\RoutingBundle\Entity\Route", mappedBy="id", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\JoinColumn(name="route_id", referencedColumnName="id")
     **/
    protected $route;

    /**
     * @ORM\Column(name="slug", type="string", length=255, nullable=false)
     */
    protected $slug;

    /**
     * Sets the entity's slug.
     *
     * @param $slug
     *
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Returns the entity's slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }


    /**
     * Sets the entity's route.
     *
     * @param $route
     */
    public function setRoute(Route $route)
    {
        $this->route = $route;
    }

    /**
     * Returns the entity's route.
     *
     * @return Route
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @ORM\PreFlush
     */
    public function generateSlug()
    {
        $fields       = $this->getSluggableFields();
        $usableValues = [];

        foreach ($fields as $field) {
            $val = $this->{$field};
            if (!empty($val)) {
                $usableValues[] = $val;
            }
        }

        $sluggableText = implode($usableValues, ' ');
        $ascii         = iconv('UTF-8', 'ASCII//TRANSLIT', $sluggableText);
        $slug          = strtolower(trim(preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $ascii), $this->getSlugDelimiter()));
        $slug          = preg_replace("/[\/_|+ -]+/", $this->getSlugDelimiter(), $slug);
        $this->slug    = $slug;
    }

    /**
     * @ORM\PreFlush
     */
    public function generateRoute()
    {
        $defaults = [
            'id'      => $this->getTranslatable()->getId(),
            '_locale' => $this->locale
        ];

        $route = new Route();
        $route->setDefaults($defaults);
        $route->setOptions([]);
        $route->setRequirements([]);
        $route->setStaticPattern($this->slug);
        $route->setStrategy($this->getRouteGeneratorStrategy());
        $this->route = $route;
    }

    /**
     * Returns delimiter used in slug generation
     *
     * @return string
     */
    private function getSlugDelimiter()
    {
        return '-';
    }
}