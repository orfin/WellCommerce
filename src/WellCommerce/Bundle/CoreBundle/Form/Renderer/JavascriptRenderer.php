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
use WellCommerce\Bundle\CoreBundle\Form\Formatter\FormatterInterface;

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
    public function render(FormInterface $form)
    {
        $attributes = $this->walkChildren($form->getChildren());

        return $this->formatter->formatAttributes($attributes);
    }

    public function getTemplateName()
    {
        return $this->template;
    }

    /**
     * @param ElementInterface $element
     *
     * @return array
     */
    protected function walkElement(ElementInterface $element)
    {
        $attributes = $this->formatter->formatElement($element);
        $children   = $element->getChildren();

        if ($children->count()) {
            $this->formatter->formatChildren($this->walkChildren($children), $attributes);
        }

        return $attributes;
    }

    /**
     * @param ElementCollection $children
     *
     * @return array
     */
    protected function walkChildren(ElementCollection $children)
    {
        $attributes = [];

        foreach ($children->all() as $child) {
            $attributes[] = $this->walkElement($child);
        }

        return $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($type)
    {
        return 'js' === strtolower($type);
    }
} 