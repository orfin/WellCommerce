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

namespace WellCommerce\Bundle\SearchBundle\Mapping\Field;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SearchField
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class SearchField implements SearchFieldInterface
{
    /**
     * @var array
     */
    private $options = [];

    /**
     * ElasticSearchAdapter constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options);
    }

    public function getLabel() : string
    {
        return $this->options['label'];
    }

    public function isIndexed() : bool
    {
        return $this->options['label'];
    }

    public function getType() : string
    {
        return $this->options['label'];
    }

    public function getBoost() : float
    {
        return $this->options['label'];
    }

    public function isTranslatable() : bool
    {
        return $this->options['label'];
    }

    public function getPropertyName() : string
    {
        return $this->options['label'];
    }
    
    public function getAnalyzer()
    {
        return $this->options['label'];
    }

    private function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'label',
            'indexed',
            'type',
            'boost',
            'translatable',
            'property_name',
            'analyzer',
        ]);

        $resolver->setDefault('indexed', true);
        $resolver->setDefault('type', 'text');
        $resolver->setDefault('boost', 1);
        $resolver->setDefault('translatable', true);
        $resolver->setDefault('analyzer', null);

        $resolver->setAllowedTypes('label', 'text');
        $resolver->setAllowedTypes('indexed', 'bool');
        $resolver->setAllowedTypes('type', 'string');
        $resolver->setAllowedTypes('boost', 'float');
        $resolver->setAllowedTypes('translatable', 'bool');
        $resolver->setAllowedTypes('property_name', 'string');
        $resolver->setAllowedTypes('analyzer', ['string', 'null']);

        $resolver->setAllowedValues('type', ['text_field', 'select']);
    }
}
