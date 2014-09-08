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
 * Class LayoutBoxesList
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxesList extends AbstractField implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'name',
            'boxes',
            'property_path',
        ]);

        $resolver->setOptional([
            'label',
            'comment',
            'dependencies',
            'filters',
            'rules',
            'transformer',
        ]);

        $resolver->setDefaults([
            'property_path' => null,
            'transformer'   => null,
            'dependencies'  => [],
            'filters'       => [],
            'rules'         => [],
        ]);

        $resolver->setAllowedTypes([
            'name'          => ['int', 'string'],
            'label'         => 'string',
            'comment'       => 'string',
            'boxes'         => 'array',
            'dependencies'  => 'array',
            'filters'       => 'array',
            'rules'         => 'array',
            'property_path' => ['null', 'object'],
            'transformer'   => ['null', 'object'],
        ]);
    }

    public function prepareAttributesJs()
    {
        $attributes = [
            $this->formatAttributeJs('name', 'sName'),
            $this->formatAttributeJs('label', 'sLabel'),
            $this->formatAttributeJs('comment', 'sComment'),
            $this->formatAttributeJs('error', 'sError'),
            $this->formatAttributeJs('boxes', 'aoBoxes', ElementInterface::TYPE_OBJECT),
            $this->formatRulesJs(),
            $this->formatDependencyJs(),
            $this->formatDefaultsJs()
        ];

        return $attributes;
    }

}
