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
 * Class StaticListing
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class StaticListing extends AbstractField implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function prepareAttributesJs()
    {
        return [
            $this->formatAttributeJs('label', 'sLabel'),
            $this->formatAttributeJs('name', 'sName'),
            $this->formatAttributeJs('title', 'sTitle'),
            $this->formatListItemsJs('values', 'aoValues'),
            $this->formatAttributeJs('collapsible', 'bCollapsible', ElementInterface::TYPE_BOOLEAN),
            $this->formatAttributeJs('expanded', 'bExpanded', ElementInterface::TYPE_BOOLEAN),
            $this->formatDependencyJs()
        ];
    }

    protected function formatListItemsJs($attributeName, $name)
    {
        if (!isset($this->attributes[$attributeName]) || !is_array($this->attributes[$attributeName])) {
            return '';
        }
        $options = [];
        foreach ($this->attributes[$attributeName] as $option) {
            $value     = addslashes($option->value);
            $label     = addslashes($option->label);
            $options[] = "{sValue: '{$value}', sCaption: '{$label}'}";
        }

        return $name . ': [' . implode(', ', $options) . ']';
    }

    /**
     * {@inheritdoc}
     */
    public function renderStatic()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function populate($value)
    {
    }

}
