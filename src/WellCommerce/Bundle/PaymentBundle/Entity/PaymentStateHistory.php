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

use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;

/**
 * Class PaymentStateHistory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentStateHistory extends AbstractEntity implements PaymentStateHistoryInterface
{
    use Timestampable;
    use Blameable;

    /**
     * @var PaymentInterface
     */
    protected $payment;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var string
     */
    protected $comment;

    /**
     * {@inheritdoc}
     */
    public function setPayment(PaymentInterface $payment)
    {
        $this->payment = $payment;
    }

    /**
     * {@inheritdoc}
     */
    public function getPayment() : PaymentInterface
    {
        return $this->payment;
    }

    /**
     * {@inheritdoc}
     */
    public function getState() : string
    {
        return $this->state;
    }

    /**
     * {@inheritdoc}
     */
    public function setState(string $state)
    {
        $this->state = $state;
    }

    /**
     * {@inheritdoc}
     */
    public function getComment() : string
    {
        return $this->comment;
    }

    /**
     * {@inheritdoc}
     */
    public function setComment(string $comment)
    {
        $this->comment = $comment;
    }
}
