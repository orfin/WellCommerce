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
namespace WellCommerce\Bundle\CoreBundle\Form\Elements\Editor;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\CoreBundle\Form\Elements\AbstractField;
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;

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
    public function prepareAttributes()
    {
        return parent::prepareAttributes() + [
            'sSetId'                     => $this->getOption('set'),
            'aoAttributes'               => $this->getOption('attributes'),
            'sDeleteAttributeRoute'      => $this->getOption('delete_attribute_route'),
            'sRenameAttributeRoute'      => $this->getOption('rename_attribute_route'),
            'sRenameAttributeValueRoute' => $this->getOption('rename_attribute_value_route'),
        ];
    }
}
