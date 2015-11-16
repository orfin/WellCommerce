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

namespace WellCommerce\Bundle\SalesBundle\Processor;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\Bundle\FormBundle\Dependencies\DependencyInterface;
use WellCommerce\Bundle\FormBundle\Elements\ElementInterface;
use WellCommerce\Bundle\FormBundle\FormBuilderInterface;
use WellCommerce\Bundle\SalesBundle\Entity\PaymentMethodConfigurationInterface;

/**
 * Class AbstractPaymentProcessor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractPaymentProcessor extends AbstractContainerAware implements PaymentMethodProcessorInterface
{
    protected $name;
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

    protected function getFieldName($name)
    {
        return sprintf('%s_%s', $this->alias, $name);
    }

    /**
     * {@inheritdoc}
     */
    abstract function addConfigurationFields(FormBuilderInterface $builder, ElementInterface $fieldset, DependencyInterface $dependency);

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
