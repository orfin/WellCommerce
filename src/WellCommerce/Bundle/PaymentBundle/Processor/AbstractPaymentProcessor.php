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
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodConfigurationInterface;
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
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $alias;

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
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
        return sprintf('%s_%s', $this->alias, $name);
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
    public function processConfiguration(Collection $collection)
    {
        $config = [];

        $collection->map(function (PaymentMethodConfigurationInterface $configuration) use (&$config) {
            $config[$configuration->getName()] = $configuration->getValue();
        });

        return $config;
    }
}
