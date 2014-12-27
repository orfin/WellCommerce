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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements\Button;

use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;

/**
 * Class Submit
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Submit extends AbstractButton implements ElementInterface
{


    /**
     * {@inheritdoc}
     */
    public function prepareAttributesJs()
    {
        $attributes = [
            $this->formatAttributeJs('name', 'sName'),
            $this->formatAttributeJs('class', 'sClass'),
            $this->formatAttributeJs('label', 'sLabel'),
            $this->formatAttributeJs('icon', 'sIcon'),
            $this->formatDependencyJs()
        ];

        return $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function populate($value)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function setPropertyPath()
    {
        $this->attributes['property_path'] = null;
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequest($data)
    {
        return null;
    }
}
