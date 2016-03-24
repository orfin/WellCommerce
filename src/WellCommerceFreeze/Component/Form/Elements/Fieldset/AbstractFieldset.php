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

namespace WellCommerce\Component\Form\Elements\Fieldset;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\Form\DataTransformer\DataTransformerInterface;
use WellCommerce\Component\Form\Elements\AbstractContainer;

/**
 * Class AbstractFieldset
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractFieldset extends AbstractContainer
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'dependencies' => [],
            'filters'      => [],
            'rules'        => [],
            'transformer'  => null,
        ]);

        $resolver->setAllowedTypes('dependencies', 'array');
        $resolver->setAllowedTypes('filters', 'array');
        $resolver->setAllowedTypes('rules', 'array');
        $resolver->setAllowedTypes('transformer', ['null', DataTransformerInterface::class]);
    }
}
