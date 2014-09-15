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

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class Tree
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Tree extends AbstractField implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolverInterface $resolver)
    {
        parent::configureAttributes($resolver);

        $resolver->setRequired([
            'name',
            'label',
        ]);

        $resolver->setOptional([
            'addLabel',
            'selectable',
            'selector',
            'choosable',
            'clickable',
            'deletable',
            'sortable',
            'retractable',
            'addable',
            'total',
            'restrict',
            'items',
            'onClick',
            'onDuplicate',
            'onAdd',
            'onAfterAdd',
            'onDelete',
            'onAfterDelete',
            'onSaveOrder',
            'active',
            'onAfterDeleteId',
            'add_item_prompt',
            'getchildren',
            'prevent_duplicates',
            'prevent_duplicates_on_all_levels',
            'set',
            'clickable_root',
        ]);

        $total = function (Options $options) {
            return count($options['items']);
        };

        $resolver->setDefaults([
            'total'         => $total,
        ]);

        $resolver->setAllowedTypes([
            'addLabel'                         => 'string',
            'selectable'                       => 'bool',
            'selector'                         => 'string',
            'choosable'                        => 'bool',
            'clickable'                        => 'bool',
            'deletable'                        => 'bool',
            'sortable'                         => 'bool',
            'retractable'                      => 'bool',
            'addable'                          => 'bool',
            'total'                            => 'int',
            'restrict'                         => ['bool', 'array', 'int', 'string'],
            'items'                            => ['array', 'null'],
            'onClick'                          => 'string',
            'onDuplicate'                      => 'string',
            'onAdd'                            => 'string',
            'onAfterAdd'                       => 'string',
            'onDelete'                         => 'string',
            'onAfterDelete'                    => 'string',
            'onSaveOrder'                      => 'string',
            'active'                           => ['string', 'array', 'int'],
            'onAfterDeleteId'                  => 'int',
            'add_item_prompt'                  => 'string',
            'getchildren'                      => 'object',
            'prevent_duplicates'               => 'bool',
            'prevent_duplicates_on_all_levels' => 'bool',
            'clickable_root'                   => 'bool',
            'set'                              => 'string',
        ]);
    }

    public function prepareAttributesJs()
    {
        return [
            $this->formatAttributeJs('name', 'sName'),
            $this->formatAttributeJs('label', 'sLabel'),
            $this->formatAttributeJs('addLabel', 'sAddLabel'),
            $this->formatAttributeJs('error', 'sError'),
            $this->formatAttributeJs('selectable', 'bSelectable'),
            $this->formatAttributeJs('choosable', 'bChoosable'),
            $this->formatAttributeJs('clickable', 'bClickable'),
            $this->formatAttributeJs('deletable', 'bDeletable'),
            $this->formatAttributeJs('sortable', 'bSortable'),
            $this->formatAttributeJs('retractable', 'bRetractable'),
            $this->formatAttributeJs('addable', 'bAddable'),
            $this->formatAttributeJs('total', 'iTotal'),
            $this->formatAttributeJs('restrict', 'iRestrict'),
            $this->formatAttributeJs('items', 'oItems', ElementInterface::TYPE_OBJECT),
            $this->formatAttributeJs('onClick', 'fOnClick', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('onDuplicate', 'fOnDuplicate', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('onAdd', 'fOnAdd', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('onAfterAdd', 'fOnAfterAdd', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('onDelete', 'fOnDelete', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('onAfterDelete', 'fOnAfterDelete', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('onSaveOrder', 'fOnSaveOrder', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('active', 'sActive'),
            $this->formatAttributeJs('onAfterDeleteId', 'sOnAfterDeleteId'),
            $this->formatAttributeJs('add_item_prompt', 'sAddItemPrompt'),
            $this->formatAttributeJs('getchildren', 'fGetChildren', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('prevent_duplicates', 'bPreventDuplicates', ElementInterface::TYPE_BOOLEAN),
            $this->formatAttributeJs('prevent_duplicates_on_all_levels', 'bPreventDuplicatesOnAllLevels', ElementInterface::TYPE_BOOLEAN),
            $this->formatAttributeJs('set', 'sSet'),
            $this->formatRepeatableJs(),
            $this->formatRulesJs(),
            $this->formatDependencyJs(),
        ];
    }
}
