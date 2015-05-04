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

/**
 * Class Dimension
 *
 * @ORM\Embeddable
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Dimension
{
    /**
     * @var float
     *
     * @ORM\Column(name="depth", type="decimal", precision=15, scale=4)
     */
    private $depth;

    /**
     * @var float
     *
     * @ORM\Column(name="width", type="decimal", precision=15, scale=4)
     */
    private $width;

    /**
     * @var float
     *
     * @ORM\Column(name="height", type="decimal", precision=15, scale=4)
     */
    private $height;

    /**
     * Constructor
     *
     * @param int $depth
     * @param int $width
     * @param int $height
     */
    public function __construct($depth = 0, $width = 0, $height = 0)
    {
        $this->depth  = $depth;
        $this->width  = $width;
        $this->height = $height;
    }

    /**
     * @return float
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * @param float $depth
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;
    }

    /**
     * @return float
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param float $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return float
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param float $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }
}