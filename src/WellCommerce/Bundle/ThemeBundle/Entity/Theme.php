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

namespace WellCommerce\Bundle\ThemeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Theme
 *
 * @ORM\Table("theme")
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\ThemeBundle\Repository\ThemeRepository")
 */
class Theme
{
    use ORMBehaviors\Timestampable\Timestampable;
    use ORMBehaviors\Blameable\Blameable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="folder", type="string", length=255)
     */
    protected $folder;

    /**
     * @ORM\OneToMany(targetEntity="WellCommerce\Bundle\ThemeBundle\Entity\ThemeCss", mappedBy="theme")
     */
    protected $css;

    /**
     * Returns the theme's identifier
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the theme's name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the theme's name
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns theme's folder name
     *
     * @return string
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * Sets theme's folder name
     *
     * @param $folder
     *
     * @return $this
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * Returns the theme's CSS values
     *
     * @return ThemeCss[]
     */
    public function getCss()
    {
        return $this->css;
    }

    /**
     * Sets an array of css values for theme
     *
     * @param array $css
     *
     * @return $this
     */
    public function setCss($css)
    {
        $this->css = $css;

        return $this;
    }
}
