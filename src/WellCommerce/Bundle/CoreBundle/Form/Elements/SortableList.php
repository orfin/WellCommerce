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

/**
 * Class SortableList
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SortableList extends AbstractField implements ElementInterface
{
    public function prepareAttributesJs()
    {
        return [
            $this->formatAttributeJs('name', 'sName'),
            $this->formatAttributeJs('label', 'sLabel'),
            $this->formatAttributeJs('error', 'sError'),
            $this->formatAttributeJs('clickable', 'bClickable'),
            $this->formatAttributeJs('deletable', 'bDeletable'),
            $this->formatAttributeJs('sortable', 'bSortable'),
            $this->formatAttributeJs('addable', 'bAddable'),
            $this->formatAttributeJs('items', 'oItems', ElementInterface::TYPE_OBJECT),
            $this->formatAttributeJs('total', 'iTotal'),
            $this->formatAttributeJs('onClick', 'fOnClick', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('onAdd', 'fOnAdd', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('onAfterAdd', 'fOnAfterAdd', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('onDelete', 'fOnDelete', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('onAfterDelete', 'fOnAfterDelete', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('onSaveOrder', 'fOnSaveOrder', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('active', 'sActive'),
            $this->formatAttributeJs('add_item_prompt', 'sAddItemPrompt'),
            $this->formatAttributeJs('delete_item_prompt', 'sDeleteItemPrompt'),
            $this->formatAttributeJs('set', 'sSet'),
            $this->formatRepeatableJs(),
            $this->formatRulesJs(),
            $this->formatDependencyJs(),
            $this->formatDefaultsJs()
        ];
    }
}
