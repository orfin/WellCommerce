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

namespace WellCommerce\Bundle\OrderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use WellCommerce\Bundle\IntlBundle\ORM\LocaleAwareInterface;

/**
 * OrderStatusTranslation
 *
 * @ORM\Table(name="order_status_translation")
 * @ORM\Entity
 */
class OrderStatusTranslation implements LocaleAwareInterface
{
    use Translation;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="default_comment", type="text")
     */
    private $defaultComment;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDefaultComment()
    {
        return $this->defaultComment;
    }

    /**
     * @param string $defaultComment
     */
    public function setDefaultComment($defaultComment)
    {
        $this->defaultComment = $defaultComment;
    }
}
