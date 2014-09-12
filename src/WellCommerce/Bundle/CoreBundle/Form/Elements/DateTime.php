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

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class DateTime
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DateTime extends TextField implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'name',
            'label',
        ]);

        $resolver->setOptional([
            'comment',
            'error',
            'error',
            'minDate',
            'maxDate',
            'default',
            'property_path',
            'dependencies',
            'filters',
            'rules',
            'transformer'
        ]);

        $resolver->setDefaults([
            'default'       => null,
            'dependencies'  => [],
            'filters'       => [],
            'rules'         => [],
            'property_path' => null,
            'transformer'   => null
        ]);

        $resolver->setAllowedTypes([
            'name'          => 'string',
            'label'         => 'string',
            'comment'       => 'string',
            'error'         => 'string',
            'minDate'       => 'string',
            'maxDate'       => 'string',
            'default'       => ['string', 'integer', 'null'],
            'rules'         => 'array',
            'dependencies'  => 'array',
            'property_path' => ['null', 'Symfony\Component\PropertyAccess\PropertyPath'],
            'transformer'   => ['null', 'WellCommerce\Bundle\CoreBundle\Form\DataTransformerInterface'],
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
            $this->formatRepeatableJs(),
            $this->formatRulesJs(),
            $this->formatDependencyJs(),
            $this->formatDefaultsJs()
        ];
    }
}
