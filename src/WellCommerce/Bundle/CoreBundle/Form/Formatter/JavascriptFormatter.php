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

namespace WellCommerce\Bundle\CoreBundle\Form\Formatter;

use Doctrine\Common\Util\ClassUtils;
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;
use WellCommerce\Bundle\CoreBundle\Form\Formatter\Javascript as Javascript;
use Zend\Json\Expr;
use Zend\Json\Json;

/**
 * Class JavascriptFormatter
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class JavascriptFormatter implements FormatterInterface
{
    /**
     * {@inheritdoc}
     */
    public function formatAttributes(array $attributes = [])
    {
        $json    = Json::encode($attributes, false, ['enableJsonExprFinder' => true]);
        $content = Json::prettyPrint($json, ['indent' => '    ']);

        return $content;
    }

    /**
     * {@inheritdoc}
     */
    public function formatElement(ElementInterface $element)
    {
        $attributes = $element->prepareAttributes();

        $this->formatFunctionType($element, $attributes);

        return $attributes;
    }

    /**
     * Formats elements children
     *
     * @param array $children
     * @param array $attributes
     */
    public function formatChildren(array $children = [], array &$attributes)
    {
        $attributes['aoFields'] = $children;
    }

    /**
     * Formats javascript function type
     *
     * @param ElementInterface $element
     * @param array            $attributes
     */
    protected function formatFunctionType(ElementInterface $element, array &$attributes)
    {
        $attributes['fType'] = new Expr($this->getJavascriptNodeName($element));
    }

    /**
     * Formats elements rules
     *
     * @param array $rules
     * @param array $attributes
     */
    protected function formatRules(array $rules = [], array &$attributes)
    {

    }

    /**
     * Formats elements dependencies
     *
     * @param array $dependencies
     * @param array $attributes
     */
    public function formatDependencies(array $dependencies = [], array &$attributes)
    {

    }

    /**
     * Returns element javascript-friendly name
     *
     * @param ElementInterface $element
     *
     * @return string
     */
    protected function getJavascriptNodeName(ElementInterface $element)
    {
        $class = $this->getElementClass($element);
        $parts = explode('\\', $class);

        return 'GForm' . end($parts);
    }

    /**
     * Returns FQCN for element
     *
     * @param ElementInterface $element
     *
     * @return string
     */
    protected function getElementClass(ElementInterface $element)
    {
        return ltrim(ClassUtils::getClass($element), '\\');
    }
} 