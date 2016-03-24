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

namespace WellCommerce\Bundle\DelivererBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;
use WellCommerce\Bundle\ProducerBundle\Entity\ProducerInterface;

/**
 * Class Deliverer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Deliverer extends AbstractEntity implements DelivererInterface
{
    use Translatable;
    use Timestampable;
    use Blameable;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var Collection
     */
    protected $producers;

    /**
     * {@inheritdoc}
     */
    public function getProducers() : Collection
    {
        return $this->producers;
    }

    /**
     * {@inheritdoc}
     */
    public function setProducers(Collection $collection)
    {
        $this->producers = $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function addProducer(ProducerInterface $producer)
    {
        $this->producers[] = $producer;
    }
}
