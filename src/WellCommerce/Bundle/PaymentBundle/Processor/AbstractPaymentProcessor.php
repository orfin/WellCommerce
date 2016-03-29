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

namespace WellCommerce\Bundle\PaymentBundle\Processor;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodConfigurationInterface;
use WellCommerce\Bundle\PaymentBundle\Manager\Front\PaymentManagerInterface;
use WellCommerce\Component\Form\Dependencies\DependencyInterface;
use WellCommerce\Component\Form\Elements\ElementInterface;
use WellCommerce\Component\Form\FormBuilderInterface;

/**
 * Class AbstractPaymentProcessor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractPaymentProcessor extends AbstractContainerAware implements PaymentMethodProcessorInterface
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @var PaymentManagerInterface
     */
    protected $paymentManager;

    /**
     * AbstractPaymentProcessor constructor.
     *
     * @param PaymentManagerInterface $paymentManager
     * @param array                   $options
     */
    public function __construct(PaymentManagerInterface $paymentManager, array $options)
    {
        $this->paymentManager = $paymentManager;
        $resolver             = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'name',
            'alias',
        ]);

        $resolver->setAllowedTypes('name', 'string');
        $resolver->setAllowedTypes('alias', 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias() : string
    {
        return $this->options['alias'];
    }

    /**
     * {@inheritdoc}
     */
    public function getName() : string
    {
        return $this->options['name'];
    }

    /**
     * Returns the field name used in forms
     *
     * @param string $name
     *
     * @return string
     */
    protected function getFieldName($name)
    {
        return sprintf('%s_%s', $this->getAlias(), $name);
    }

    /**
     * {@inheritdoc}
     */
    abstract public function addConfigurationFields(
        FormBuilderInterface $builder,
        ElementInterface $fieldset,
        DependencyInterface $dependency
    );

    /**
     * {@inheritdoc}
     */
    public function processConfiguration(Collection $collection) : array
    {
        $config = [];

        $collection->map(function (PaymentMethodConfigurationInterface $configuration) use (&$config) {
            $config[$configuration->getName()] = $configuration->getValue();
        });

        return $config;
    }

    /**
     * {@inheritdoc}
     */
    public function processPayment(PaymentInterface $payment) : PaymentInterface
    {
        return $payment;
    }

    /**
     * {@inheritdoc}
     */
    public function confirmPayment(Request $request) : PaymentInterface
    {
        throw new \LogicException(sprintf('Payment processor "%s" does not allow payment confirmation', $this->getAlias()));
    }

    /**
     * {@inheritdoc}
     */
    public function cancelPayment(OrderInterface $order, Request $request) : PaymentInterface
    {
        throw new \LogicException(sprintf('Payment processor "%s" does not allow payment cancellation', $this->getAlias()));
    }

    /**
     * {@inheritdoc}
     */
    public function notifyPayment(Request $request) : PaymentInterface
    {
        throw new \LogicException(sprintf('Payment processor "%s" does not allow payment notification', $this->getAlias()));
    }

    protected function getConfirmUrl() : string
    {
        return $this->getRouterHelper()->generateUrl('front.payment.confirm', ['processor' => $this->getAlias()]);
    }

    protected function getCancelUrl() : string
    {
        return $this->getRouterHelper()->generateUrl('front.payment.cancel', ['processor' => $this->getAlias()]);
    }

    protected function getNotifyUrl() : string
    {
        return $this->getRouterHelper()->generateUrl('front.payment.notify', ['processor' => $this->getAlias()]);
    }
}
