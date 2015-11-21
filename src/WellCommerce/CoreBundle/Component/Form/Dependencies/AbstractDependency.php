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
namespace WellCommerce\CoreBundle\Component\Form\Dependencies;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbstractDependency
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractDependency implements DependencyInterface
{
    /**
     * @var \Symfony\Component\OptionsResolver\OptionsResolver
     */
    protected $optionsResolver;

    /**
     * @var array
     */
    protected $options;

    public function setOptions(array $options = [])
    {
        $optionsResolver = new OptionsResolver();
        $this->configureOptions($optionsResolver);
        $this->options = $optionsResolver->resolve($options);

        return $this;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'field',
            'form',
            'condition',
        ]);

        $resolver->setAllowedTypes([
            'field'     => 'WellCommerce\CoreBundle\Component\Form\Elements\ElementInterface',
            'form'      => 'WellCommerce\CoreBundle\Component\Form\Elements\Form',
            'condition' => 'WellCommerce\CoreBundle\Component\Form\Conditions\ConditionInterface',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    abstract public function getJavascriptType();

    /**
     * Returns field to which dependency is bound
     *
     * @return \WellCommerce\CoreBundle\Component\Form\Elements\ElementInterface
     */
    protected function getField()
    {
        return $this->options['field'];
    }

    /**
     * Returns form instance
     *
     * @return \WellCommerce\CoreBundle\Component\Form\Elements\Form
     */
    protected function getForm()
    {
        return $this->options['form'];
    }

    /**
     * Returns dependency condition
     *
     * @return \WellCommerce\CoreBundle\Component\Form\Conditions\ConditionInterface
     */
    protected function getCondition()
    {
        return $this->options['condition'];
    }

    /**
     * Returns javascript part for dependency
     *
     * @return string
     */
    public function renderJs()
    {
        $javascriptType      = $this->getJavascriptType();
        $conditionJavascript = $this->getCondition()->renderJs();
        $fieldName           = $this->getField()->getName();
        $formName            = $this->getForm()->getName();

        return sprintf("new GFormDependency(GFormDependency.%s, '%s.%s', %s)",
            $javascriptType,
            $formName,
            $fieldName,
            $conditionJavascript
        );
    }
}
