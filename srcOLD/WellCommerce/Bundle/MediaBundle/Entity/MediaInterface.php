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

namespace WellCommerce\Bundle\MediaBundle\Entity;

use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;

/**
 * Interface MediaInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface MediaInterface extends TimestampableInterface, BlameableInterface
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
    public function getPath();

    /**
     * @param string $path
     */
    public function setPath($path);

    /**
     * @return string
     */
    public function getMime();

    /**
     * @param string $mime
     */
    public function setMime($mime);

    /**
     * @return int
     */
    public function getSize();

    /**
     * @param int $size
     */
    public function setSize($size);

    /**
     * @return string
     */
    public function getFullName();

    /**
     * @return string
     */
    public function getExtension();

    /**
     * @param string $extension
     */
    public function setExtension($extension);
}
