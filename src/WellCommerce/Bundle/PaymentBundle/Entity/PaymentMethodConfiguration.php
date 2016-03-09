<?php

namespace WellCommerce\Bundle\PaymentBundle\Entity;

use WellCommerce\Bundle\DoctrineBundle\Behaviours\Timestampable\TimestampableTrait;

/**
 * Class PaymentMethodConfiguration
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodConfiguration implements PaymentMethodConfigurationInterface
{
    use TimestampableTrait;
    use PaymentMethodAwareTrait;

    /**
     * @var int
     */
    protected $id;

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
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
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
