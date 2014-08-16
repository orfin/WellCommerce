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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use WellCommerce\Bundle\ProducerBundle\Entity\Producer;

/**
 * Class Locale
 *
 * @package WellCommerce\Bundle\DelivererBundle\Entity
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @ORM\Table(name="deliverer")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\DelivererBundle\Repository\DelivererRepository")
 */
class Deliverer
{
    use ORMBehaviors\Translatable\Translatable;
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
     * @ORM\ManyToMany(targetEntity="WellCommerce\Bundle\ProducerBundle\Entity\Producer", inversedBy="deliverers")
     * @ORM\JoinTable(name="producer_deliverer",
     *      joinColumns={@ORM\JoinColumn(name="deliverer_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="producer_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    private $producers;

    /**
     * Get id.
    
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets producers for deliverer
     *
     * @param $shops
     */
    public function setProducers(ArrayCollection $collection)
    {
        $this->producers = $collection;
    }

    /**
     * Get producers for deliverer
     *
     * @return mixed
     */
    public function getProducers()
    {
        return $this->producers;
    }

    public function addProducer(Producer $producer)
    {
        $this->producers[] = $producer;
    }
}

