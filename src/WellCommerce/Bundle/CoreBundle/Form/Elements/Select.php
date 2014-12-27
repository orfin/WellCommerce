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
 * Class Select
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Select extends AbstractOptionedField implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function prepareAttributesJs()
    {
        return [
            $this->formatAttributeJs('name', 'sName'),
            $this->formatAttributeJs('label', 'sLabel'),
            $this->formatAttributeJs('comment', 'sComment'),
            $this->formatAttributeJs('suffix', 'sSuffix'),
            $this->formatAttributeJs('prefix', 'sPrefix'),
            $this->formatAttributeJs('error', 'sError'),
            $this->formatAttributeJs('selector', 'sSelector'),
            $this->formatAttributeJs('css_attribute', 'sCssAttribute'),
            $this->formatAttributeJs('addable', 'bAddable'),
            $this->formatAttributeJs('onAdd', 'fOnAdd', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('add_item_prompt', 'sAddItemPrompt'),
            $this->formatRulesJs(),
            $this->formatDependencyJs(),
            $this->formatOptionsJs(),
        ];
    }
}
