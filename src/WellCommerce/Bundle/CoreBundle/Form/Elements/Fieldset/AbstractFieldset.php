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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements\Fieldset;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\CoreBundle\Form\Elements\AbstractContainer;

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
    public function configureAttributes(OptionsResolver $resolver)
    {
        $resolver->setDefined([
            'property_path',
            'dependencies',
            'filters',
            'rules',
            'transformer'
        ]);

        $resolver->setDefaults([
            'property_path' => null
        ]);

        $resolver->setAllowedTypes([
            'dependencies'  => 'array',
            'property_path' => ['null', 'Symfony\Component\PropertyAccess\PropertyPath'],
            'transformer'   => ['null', 'WellCommerce\Bundle\CoreBundle\Form\DataTransformer\DataTransformerInterface'],
        ]);
    }
}