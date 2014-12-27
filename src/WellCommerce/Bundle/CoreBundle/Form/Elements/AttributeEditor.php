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

/**
 * Class AttributeEditor
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeEditor extends AbstractField implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolver $resolver)
    {
        parent::configureAttributes($resolver);

        $resolver->setRequired([
            'set',
            'delete_attribute_route',
            'rename_attribute_route',
            'rename_attribute_value_route',
            'attributes',
        ]);

        $resolver->setDefaults([
            'attributes' => []
        ]);

        $resolver->setAllowedTypes([
            'set'                          => ['int', 'string', 'null'],
            'attributes'                   => 'array',
            'delete_attribute_route'       => 'string',
            'rename_attribute_route'       => 'string',
            'rename_attribute_value_route' => 'string',
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
            $this->formatAttributeJs('set', 'sSetId'),
            $this->formatAttributeJs('attributes', 'aoAttributes', ElementInterface::TYPE_OBJECT),
            $this->formatAttributeJs('delete_attribute_route', 'sDeleteAttributeRoute'),
            $this->formatAttributeJs('rename_attribute_route', 'sRenameAttributeRoute'),
            $this->formatAttributeJs('rename_attribute_value_route', 'sRenameAttributeValueRoute'),
            $this->formatRulesJs(),
            $this->formatDependencyJs(),
        ];
    }
}
