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

namespace WellCommerce\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Routing\Route as BaseRoute;

/**
 * Class Route
 *
 * @package WellCommerce\Bundle\CoreBundle\Routing
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @ORM\Table("routes")
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\CoreBundle\Repository\RouteRepository")
 */
class Route extends BaseRoute
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
     * @var string
     *
     * @ORM\Column(name="static_prefix", type="string", length=255, nullable=false)
     */
    private $staticPrefix;

    /**
     * @var string
     *
     * @ORM\Column(name="variable_pattern", type="string", length=255, nullable=false)
     */
    private $variablePattern;

    /**
     * @ORM\Column(type="string")
     */
    private $locale;

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
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param mixed $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function getStaticPrefix()
    {
        return $this->staticPrefix;
    }

    /**
     * @param string $staticPrefix
     */
    public function setStaticPrefix($staticPrefix)
    {
        $this->staticPrefix = $staticPrefix;
    }

    /**
     * @return string
     */
    public function getVariablePattern()
    {
        return $this->variablePattern;
    }

    /**
     * @param string $variablePattern
     */
    public function setVariablePattern($variablePattern)
    {
        $this->variablePattern = $variablePattern;
    }

} 