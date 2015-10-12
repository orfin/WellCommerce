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

use Doctrine\Common\Util\Debug;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\Bundle\FormBundle\Conditions\Equals;
use WellCommerce\Bundle\FormBundle\Elements\ElementInterface;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;
use WellCommerce\Bundle\FormBundle\FormBuilderInterface;

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

    /**
     * {@inheritdoc}
     */
    public function addConfigurationFieldset(FormBuilderInterface $builder, FormInterface $form, ElementInterface $processorTypeSelect)
    {
        $configurationData = $form->addChild($builder->getElement('nested_fieldset', [
            'name'         => $this->alias,
            'label'        => $this->trans($this->getName()),
            'dependencies' => [
                $builder->getDependency('show', [
                    'form'      => $form,
                    'field'     => $processorTypeSelect,
                    'condition' => new Equals($this->alias)
                ])
            ]
        ]));

        $this->addConfigurationFields($builder, $configurationData);
    }

    /**
     * Adds configuration fields
     *
     * @param FormBuilderInterface $builder
     * @param ElementInterface     $configurationData
     */
    abstract protected function addConfigurationFields(FormBuilderInterface $builder, ElementInterface $configurationData);
}
