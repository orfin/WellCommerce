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

namespace WellCommerce\Bundle\FormBundle\Renderer;

use WellCommerce\Bundle\FormBundle\Elements\Attribute;
use WellCommerce\Bundle\FormBundle\Elements\AttributeCollection;
use WellCommerce\Bundle\FormBundle\Elements\ElementCollection;
use WellCommerce\Bundle\FormBundle\Elements\ElementInterface;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;

/**
 * Class JavascriptRenderer
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class JavascriptRenderer extends AbstractFormRenderer implements FormRendererInterface
{
    /**
     * {@inheritdoc}
     */
    public function renderForm(FormInterface $form)
    {
        $attributes = $this->renderElement($form);

        return $this->formatter->formatAttributes($attributes);
    }

    /**
     * Renders single form element and seeks for its children
     *
     * @param ElementInterface $element
     *
     * @return array
     */
    protected function renderElement(ElementInterface $element)
    {
        $children   = $element->getChildren();
        $collection = $this->getAttributesCollection($element);

        if ($children->count()) {
            $attribute = new Attribute('aoFields', $this->renderChildren($children), Attribute::TYPE_ARRAY);
            $collection->add($attribute);
        }

        return $this->formatter->formatAttributesCollection($collection);
    }

    /**
     * Returns attributes collection for element
     *
     * @param ElementInterface $element
     *
     * @return AttributeCollection
     */
    protected function getAttributesCollection(ElementInterface $element)
    {
        $collection = new AttributeCollection();
        $element->prepareAttributesCollection($collection);

        return $collection;
    }

    /**
     * Renders all children elements
     *
     * @param ElementCollection $children
     *
     * @return array
     */
    protected function renderChildren(ElementCollection $children)
    {
        $attributes = [];

        $children->forAll(function (ElementInterface $child) use (&$attributes) {
            $attributes[] = $this->renderElement($child);
        });

        return $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplateName()
    {
        return $this->template;
    }
}
