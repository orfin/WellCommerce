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
use WellCommerce\Bundle\CoreBundle\DataGrid\Options\Options;

/**
 * Class AbstractField
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractField extends AbstractNode
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefined([
            'comment',
            'error',
            'default',
            'dependencies',
            'rules',
            'filters',
            'transformer',
            'property_path'
        ]);

        $resolver->setDefaults([
            'default'      => null,
            'dependencies' => [],
            'rules'        => [],
            'filters'      => [],
            'transformer'  => null
        ]);

        $resolver->setDefault('property_path', function (Options $options) {
            return new PropertyPath($options['name']);
        });

        $resolver->setAllowedTypes([
            'comment'       => 'string',
            'error'         => 'string',
            'dependencies'  => 'array',
            'rules'         => 'array',
            'filters'       => 'array',
            'transformer'   => ['null', 'WellCommerce\Bundle\CoreBundle\Form\DataTransformer\DataTransformerInterface'],
            'property_path' => ['null', 'Symfony\Component\PropertyAccess\PropertyPath'],
        ]);
    }

    /**
     * Returns elements property path
     *
     * @return null|\Symfony\Component\PropertyAccess\PropertyPath
     */
    public function getPropertyPath()
    {
        return $this->options['property_path'];
    }
}
