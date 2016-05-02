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

namespace WellCommerce\Bundle\TaxBundle\Entity;

use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;

/**
 * Class Tax
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Tax extends AbstractEntity implements TaxInterface
{
    use Translatable;
    use Timestampable;
    use Blameable;
    
    /**
     * @var float
     */
    protected $value;
    
    /**
     * {@inheritdoc}
     */
    public function getValue() : float
    {
        return $this->value;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setValue(float $value)
    {
        $this->value = $value;
    }
}
