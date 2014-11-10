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

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Route
 *
 * @package WellCommerce\Bundle\ProductBundle\Entity
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @ORM\Table(name="route")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\RoutingBundle\Repository\RouteRepository")
 */
class Route
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="static_pattern", type="string")
     */
    private $staticPattern;

    /**
     * @ORM\Column(name="defaults", type="json_array")
     */
    private $defaults;

    /**
     * @ORM\Column(name="options", type="json_array")
     */
    private $options;

    /**
     * @ORM\Column(name="requirements", type="json_array")
     */
    private $requirements;

    /**
     * @ORM\Column(name="strategy", type="string")
     */
    private $strategy;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDefaults()
    {
        return $this->defaults;
    }

    /**
     * @param mixed $defaults
     */
    public function setDefaults($defaults)
    {
        $this->defaults = $defaults;
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param mixed $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @return mixed
     */
    public function getRequirements()
    {
        return $this->requirements;
    }

    /**
     * @param mixed $requirements
     */
    public function setRequirements($requirements)
    {
        $this->requirements = $requirements;
    }

    /**
     * @return mixed
     */
    public function getStaticPattern()
    {
        return $this->staticPattern;
    }

    /**
     * @param mixed $staticPattern
     */
    public function setStaticPattern($staticPattern)
    {
        $this->staticPattern = $staticPattern;
    }

    /**
     * @return mixed
     */
    public function getStrategy()
    {
        return $this->strategy;
    }

    /**
     * @param mixed $strategy
     */
    public function setStrategy($strategy)
    {
        $this->strategy = $strategy;
    }
}

