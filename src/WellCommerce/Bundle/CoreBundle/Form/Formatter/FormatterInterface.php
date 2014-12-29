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

use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;

/**
 * Interface FormatterInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface FormatterInterface
{
    const TYPE_NUMBER   = 'number';
    const TYPE_STRING   = 'string';
    const TYPE_FUNCTION = 'function';
    const TYPE_ARRAY    = 'array';
    const TYPE_OBJECT   = 'object';
    const TYPE_BOOLEAN  = 'boolean';

    /**
     * Formats the element
     *
     * @param ElementInterface $element
     *
     * @return array
     */
    public function formatElement(ElementInterface $element);

    /**
     * Formats attributes as JSON string
     *
     * @param array $attributes
     *
     * @return string
     */
    public function formatAttributes(array $attributes = []);
}