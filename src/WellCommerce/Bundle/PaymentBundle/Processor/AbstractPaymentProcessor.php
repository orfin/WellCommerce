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

use Doctrine\Common\Util\ClassUtils;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainer;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\Elements\Fieldset;
use WellCommerce\Bundle\CoreBundle\Form\Elements\Form;

/**
 * Class AbstractPaymentProcessor
 *
 * @package WellCommerce\Bundle\PaymentBundle\Processor
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractPaymentProcessor extends AbstractContainer implements PaymentMethodProcessorInterface
{
    private function getClass()
    {
        $class = ClassUtils::getRealClass(ltrim(get_class($this), '\\'));
        $parts = explode('\\', $class);

        return end($parts);
    }

    public function getAlias()
    {
        return strtolower($this->getClass());
    }

    public function getName()
    {
        return $this->getClass();
    }

    public function addFields(FormBuilderInterface $builderInterface, Fieldset $fieldset)
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function addConfigurationFieldset(FormBuilderInterface $builder, Form $form, $resource)
    {
        $fieldset = $form->addChild($builder->getElement('fieldset', [
            'name'  => $this->getAlias(),
            'label' => $this->getName()
        ]));

        $this->addFields($builder, $fieldset);

        return $fieldset;
    }
} 