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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PropertyAccess\PropertyPath;
use WellCommerce\Bundle\CoreBundle\Form\Filters\FilterInterface;

/**
 * Class AbstractField
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractField extends AbstractContainer
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefined([
            'default',
            'comment',
            'error',
            'dependencies',
            'rules',
            'filters',
            'transformer',
        ]);

        $resolver->setDefaults([
            'default'      => null,
            'dependencies' => [],
            'rules'        => [],
            'filters'      => [],
            'transformer'  => null
        ]);

        $resolver->setNormalizer('property_path', function ($options) {
            return new PropertyPath($options['name']);
        });

        $resolver->setAllowedTypes([
            'comment'      => 'string',
            'error'        => 'string',
            'dependencies' => 'array',
            'rules'        => 'array',
            'filters'      => 'array',
            'transformer'  => ['null', 'WellCommerce\Bundle\CoreBundle\Form\DataTransformer\DataTransformerInterface'],
        ]);
    }

    protected function getFilters()
    {
        return $this->options['filters'];
    }

    /**
     * {@inheritdoc}
     */
    public function addChild(ElementInterface $element)
    {
        throw new \BadMethodCallException(
            sprintf('Cannot add child "%s" as it is allowed only for element of type fieldset', get_class($element))
        );
    }

    /**
     * {@inheritdoc}
     */
    public function addFilter(FilterInterface $filter)
    {
        $this->options['filters'][] = $filter;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesCollection(AttributeCollection $collection)
    {
        parent::prepareAttributesCollection($collection);
        $collection->add(new Attribute('sValue', $this->value));
    }
}
