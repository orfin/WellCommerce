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

namespace WellCommerce\Bundle\NewsBundle\Entity;

use DateTime;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;
use WellCommerce\Bundle\MediaBundle\Entity\MediaAwareTrait;

/**
 * Class News
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class News extends AbstractEntity implements NewsInterface
{
    use Translatable;
    use Timestampable;
    use Blameable;
    use MediaAwareTrait;
    
    /**
     * @var bool
     */
    protected $publish;
    
    /**
     * @var DateTime $startDate
     */
    protected $startDate;
    
    /**
     * @var DateTime $endDate
     */
    protected $endDate;
    
    /**
     * @var bool
     */
    protected $featured;
    
    /**
     * {@inheritdoc}
     */
    public function getPublish() : bool
    {
        return $this->publish;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setPublish(bool $publish)
    {
        $this->publish = $publish;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getStartDate() : DateTime
    {
        return $this->startDate;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setStartDate(DateTime $startDate)
    {
        $this->startDate = $startDate;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getEndDate() : DateTime
    {
        return $this->endDate;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setEndDate(DateTime $endDate)
    {
        $this->endDate = $endDate;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getFeatured() : bool
    {
        return $this->featured;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setFeatured($featured)
    {
        $this->featured = $featured;
    }
}
