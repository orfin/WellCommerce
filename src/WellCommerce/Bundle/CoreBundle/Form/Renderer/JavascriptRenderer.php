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

namespace WellCommerce\Bundle\CoreBundle\Form\Renderer;

use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementCollection;
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;
use WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface;

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
        $attributes = $this->formatter->formatElement($element);
        $children   = $element->getChildren();

        if ($children->count()) {
            $this->formatter->formatChildren($this->renderChildren($children), $attributes);
        }

        return $attributes;
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

        foreach ($children->all() as $child) {
            $attributes[] = $this->renderElement($child);
        }

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