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
namespace WellCommerce\Bundle\FormBundle\Elements\Editor;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\FormBundle\Elements\AbstractField;
use WellCommerce\Bundle\FormBundle\Elements\Attribute;
use WellCommerce\Bundle\FormBundle\Elements\AttributeCollection;
use WellCommerce\Bundle\FormBundle\Elements\ElementInterface;

/**
 * Class AttributeEditor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeEditor extends AbstractField implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'set',
            'delete_attribute_route',
            'rename_attribute_route',
            'rename_attribute_value_route',
            'attributes',
        ]);

        $resolver->setDefaults([
            'attributes' => [],
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
    public function prepareAttributesCollection(AttributeCollection $collection)
    {
        parent::prepareAttributesCollection($collection);
        $collection->add(new Attribute('sSetId', $this->getOption('set')));
        $collection->add(new Attribute('aoAttributes', $this->getOption('attributes'), Attribute::TYPE_ARRAY));
        $collection->add(new Attribute('sDeleteAttributeRoute', $this->getOption('delete_attribute_route')));
        $collection->add(new Attribute('sRenameAttributeRoute', $this->getOption('rename_attribute_route')));
        $collection->add(new Attribute('sRenameAttributeValueRoute', $this->getOption('rename_attribute_value_route')));
    }
}
