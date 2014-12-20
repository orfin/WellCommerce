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

use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use WellCommerce\Bundle\IntlBundle\ORM\LocaleAwareInterface;

/**
 * Class LayoutBoxTranslation
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxTranslation implements LocaleAwareInterface
{
    use Translation;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $content;

    /**
     * Returns primary key identifier
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns name for current translation
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets name for current translation
     *
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns content for current translation
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Sets content for current translation
     *
     * @param $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }
}
