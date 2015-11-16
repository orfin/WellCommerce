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

namespace WellCommerce\Bundle\LayoutBundle\Entity;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;

/**
 * Interface ThemeInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ThemeInterface extends TimestampableInterface, BlameableInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getFolder();

    /**
     * @param string $folder
     */
    public function setFolder($folder);

    /**
     * @return Collection|ThemeCssInterface[]
     */
    public function getCss();

    /**
     * @param Collection $css
     */
    public function setCss(Collection $css);
}
