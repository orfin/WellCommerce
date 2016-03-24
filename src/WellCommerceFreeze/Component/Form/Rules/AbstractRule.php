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
namespace WellCommerce\Component\Form\Rules;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbstractRule
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractRule implements RuleInterface
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
            'error_message',
        ]);

        $resolver->setDefault('error_message', 'validation.error.not_blank');

        $resolver->setAllowedTypes('error_message', 'string');
    }

    /**
     * {@inheritdoc}
     */
    abstract public function getJavascriptType();

    /**
     * @return string
     */
    protected function getErrorMessage()
    {
        return $this->options['error_message'];
    }

    /**
     * Returns javascript part for rule
     *
     * @return string
     */
    public function renderJs()
    {
        return '{sType: "' . $this->getJavascriptType() . '", sErrorMessage: "' . $this->getErrorMessage() . '"}';
    }
}
