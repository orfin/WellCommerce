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

namespace WellCommerce\Bundle\FormBundle\Formatter;

use WellCommerce\Bundle\FormBundle\Elements\AttributeCollection;
use WellCommerce\Bundle\FormBundle\Elements\ElementInterface;

/**
 * Interface FormatterInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface FormatterInterface
{
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

    /**
     * Formats attributes collection
     *
     * @param AttributeCollection $collection
     *
     * @return array
     */
    public function formatAttributesCollection(AttributeCollection $collection);
}
