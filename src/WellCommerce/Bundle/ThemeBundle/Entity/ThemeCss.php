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
 * ThemeCss
 *
 * @ORM\Table("theme_css")
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\ThemeBundle\Repository\ThemeCssRepository")
 */
class ThemeCss
{
    use ORMBehaviors\Timestampable\Timestampable;

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
     * @ORM\Column(name="class", type="string", length=255)
     */
    private $class;

    /**
     * @var string
     *
     * @ORM\Column(name="selector", type="string", length=255)
     */
    private $selector;

    /**
     * @var string
     *
     * @ORM\Column(name="attribute", type="string", length=255)
     */
    private $attribute;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\ThemeBundle\Entity\Theme", inversedBy="css")
     * @ORM\JoinColumn(name="theme_id", referencedColumnName="id", nullable=false)
     */
    private $theme;

    /**
     * Returns identifier
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns css atribute name
     *
     * @return string
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Sets css atribute name
     *
     * @param string $attribute
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * Returns css class
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Sets css class
     *
     * @param string $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * Returns css selector name
     *
     * @return string
     */
    public function getSelector()
    {
        return $this->selector;
    }

    /**
     * Sets css selector name
     *
     * @param string $selector
     */
    public function setSelector($selector)
    {
        $this->selector = $selector;
    }

    /**
     * Returns theme object
     *
     * @return mixed
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Sets theme object
     *
     * @param Theme $theme
     */
    public function setTheme(Theme $theme)
    {
        $this->theme = $theme;
    }
}
