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

use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use WellCommerce\Bundle\LocaleBundle\Entity\LocaleAwareInterface;

/**
 * Class OrderStatusTranslation
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderStatusTranslation implements LocaleAwareInterface
{
    use Translation;
    
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var string
     */
    protected $defaultComment;
    
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @param string $name
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
