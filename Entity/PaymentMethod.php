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

namespace WellCommerce\Bundle\PaymentBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use WellCommerce\Bundle\DoctrineBundle\Behaviours\Enableable\EnableableTrait;
use WellCommerce\Bundle\AppBundle\Entity\HierarchyAwareTrait;
use WellCommerce\Bundle\OrderBundle\Entity\OrderStatusInterface;

/**
 * Class PaymentMethod
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethod implements PaymentMethodInterface
{
    use Translatable;
    use Timestampable;
    use Blameable;
    use HierarchyAwareTrait;
    use EnableableTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $processor;

    /**
     * @var Collection
     */
    protected $shippingMethods;

    /**
     * @var OrderStatusInterface
     */
    protected $defaultOrderStatus;

    /**
     * @var Collection
     */
    protected $configuration;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getProcessor()
    {
        return $this->processor;
    }

    /**
     * {@inheritdoc}
     */
    public function setProcessor($processor)
    {
        $this->processor = $processor;
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingMethods()
    {
        return $this->shippingMethods;
    }

    /**
     * {@inheritdoc}
     */
    public function setShippingMethods(Collection $shippingMethods)
    {
        $this->shippingMethods = $shippingMethods;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultOrderStatus()
    {
        return $this->defaultOrderStatus;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOrderStatus(OrderStatusInterface $defaultOrderStatus)
    {
        $this->defaultOrderStatus = $defaultOrderStatus;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function setConfiguration(Collection $configuration)
    {
        $this->configuration = $configuration;
    }
}
