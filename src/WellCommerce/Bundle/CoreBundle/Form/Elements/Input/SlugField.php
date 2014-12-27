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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements\Input;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;

/**
 * Class TextField
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SlugField extends TextField implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'translatable_id',
            'name_field',
            'generate_route',
        ]);

        $resolver->setDefaults([
            'class' => 'sluggable'
        ]);

        $resolver->setAllowedTypes([
            'name_field'     => 'WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface',
            'generate_route' => 'string'
        ]);

        $fieldNormalizer = function (Options $options, ElementInterface $value) {
            return $value->getName();
        };

        $resolver->setNormalizers([
            'name_field' => $fieldNormalizer
        ]);
    }
}
