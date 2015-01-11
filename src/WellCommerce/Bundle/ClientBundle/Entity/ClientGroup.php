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
namespace WellCommerce\Bundle\ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * ClientGroup
 *
 * @ORM\Table(name="client_group")
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\ClientBundle\Repository\ClientGroupRepository")
 */
class ClientGroup
{
    use ORMBehaviors\Translatable\Translatable;
    use ORMBehaviors\Timestampable\Timestampable;
    use ORMBehaviors\Blameable\Blameable;

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
     * @ORM\Column(name="discount", type="decimal", precision=15, scale=4)
     */
    private $discount;

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
     * Get discount.
     *
     * @return string
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set discount.
     *
     * @param string $discount
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
    }
}

