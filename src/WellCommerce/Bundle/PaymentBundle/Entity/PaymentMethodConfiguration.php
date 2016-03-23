<?php

namespace WellCommerce\Bundle\PaymentBundle\Entity;

use WellCommerce\Bundle\DoctrineBundle\Behaviours\Timestampable\TimestampableTrait;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;

/**
 * Class PaymentMethodConfiguration
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodConfiguration extends AbstractEntity implements PaymentMethodConfigurationInterface
{
    use TimestampableTrait;
    use PaymentMethodAwareTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string|int|bool
     */
    protected $value;

    /**
     * {@inheritdoc}
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}
