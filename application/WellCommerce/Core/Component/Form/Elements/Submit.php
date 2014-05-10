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

namespace WellCommerce\Core\Component\Form\Elements;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WellCommerce\Core\Component\Form\Node;

/**
 * Class Submit
 *
 * @package WellCommerce\Core\Component\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Submit extends Node implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'name',
            'label'
        ]);

        $resolver->setOptional([
            'class',
            'icon'
        ]);

        $resolver->setAllowedTypes([
            'name'  => 'string',
            'class' => 'string',
            'label' => 'string',
            'icon'  => 'icon'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesJs()
    {
        $attributes = [
            $this->formatAttributeJs('name', 'sName'),
            $this->formatAttributeJs('class', 'sClass'),
            $this->formatAttributeJs('label', 'sLabel'),
            $this->formatAttributeJs('icon', 'sIcon'),
            $this->formatDependencyJs()
        ];

        return $attributes;
    }

    public function getValue()
    {
        return '';
    }

    public function populate($value)
    {
    }

}
