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
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\DateTransformer;

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
    public function configureAttributes(OptionsResolver $resolver)
    {
        parent::configureAttributes($resolver);

        $resolver->setDefined([
            'minDate',
            'maxDate',
        ]);

        $resolver->setAllowedTypes([
            'minDate' => 'string',
            'maxDate' => 'string',
        ]);

        $resolver->setDefaults([
            'transformer' => new DateTransformer('Y-m-d')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesJs()
    {
        return [
            $this->formatAttributeJs('name', 'sName'),
            $this->formatAttributeJs('label', 'sLabel'),
            $this->formatAttributeJs('comment', 'sComment'),
            $this->formatAttributeJs('error', 'sError'),
            $this->formatAttributeJs('minDate', 'sMinDate'),
            $this->formatAttributeJs('maxDate', 'sMaxDate'),
            $this->formatRulesJs(),
            $this->formatDependencyJs(),
        ];
    }

}
