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

namespace WellCommerce\Core\Form\Elements;

/**
 * Class DateTime
 *
 * @package WellCommerce\Core\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DateTime extends TextField implements ElementInterface
{

    public function prepareAttributesJs()
    {
        $attributes = Array(
            $this->formatAttributeJs('name', 'sName'),
            $this->formatAttributeJs('label', 'sLabel'),
            $this->formatAttributeJs('comment', 'sComment'),
            $this->formatAttributeJs('error', 'sError'),
            $this->formatAttributeJs('minDate', 'sMinDate'),
            $this->formatAttributeJs('maxDate', 'sMaxDate'),
            $this->formatRepeatableJs(),
            $this->formatRulesJs(),
            $this->formatDependencyJs(),
            $this->formatDefaultsJs()
        );

        return $attributes;
    }
}
