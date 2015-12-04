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

namespace WellCommerce\Component\Form\Elements\Input;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\Form\DataTransformer\DateTransformer;
use WellCommerce\Component\Form\Elements\ElementInterface;

/**
 * Class Date
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Date extends TextField implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'minDate',
            'maxDate',
        ]);

        $resolver->setDefaults([
            'minDate'     => '',
            'maxDate'     => '',
            'transformer' => new DateTransformer('Y-m-d'),
        ]);

        $resolver->setAllowedTypes('minDate', 'string');
        $resolver->setAllowedTypes('maxDate', 'string');
    }
}
