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

namespace WellCommerce\Component\Form\Renderer;

use WellCommerce\Component\Form\Elements\Attribute;
use WellCommerce\Component\Form\Elements\AttributeCollection;
use WellCommerce\Component\Form\Elements\ElementCollection;
use WellCommerce\Component\Form\Elements\ElementInterface;
use WellCommerce\Component\Form\Elements\FormInterface;
use WellCommerce\Component\Form\Formatter\FormatterInterface;

/**
 * Class JavascriptRenderer
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class JavascriptRenderer implements FormRendererInterface
{
    /**
     * @var FormatterInterface
     */
    protected $formatter;

    /**
     * @var string
     */
    protected $template;

    /**
     * Constructor
     *
     * @param FormatterInterface $formatter
     * @param                    $template
     */
    public function __construct(FormatterInterface $formatter, $template)
    {
        $this->formatter = $formatter;
        $this->template  = $template;
    }

    /**
     * {@inheritdoc}
     */
    public function renderForm(FormInterface $form)
    {
        $attributes = $this->renderElement($form);

        return $this->formatter->formatAttributes($attributes);
    }

    /**
     * Renders single form element with additional attributes
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

        if ($element->hasOption('dependencies') && count($element->getOption('dependencies'))) {
            $dependencies = $this->formatter->formatDependencies($element->getOption('dependencies'));
            $collection->add(new Attribute('agDependencies', $dependencies, Attribute::TYPE_ARRAY));
        }

        if ($element->hasOption('rules') && count($element->getOption('rules'))) {
            $rules = $this->formatter->formatRules($element->getOption('rules'));
            $collection->add(new Attribute('aoRules', $rules, Attribute::TYPE_ARRAY));
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
