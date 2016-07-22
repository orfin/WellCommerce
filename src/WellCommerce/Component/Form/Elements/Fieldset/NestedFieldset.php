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

namespace WellCommerce\Component\Form\Elements\Fieldset;

use WellCommerce\Component\Form\Elements\ElementInterface;

/**
 * Class NestedFieldset
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class NestedFieldset extends AbstractFieldset implements FieldsetInterface
{
    /**
     * {@inheritdoc}
     */
    public function setValue($data)
    {
        $accessor = $this->getPropertyAccessor();

        $this->getChildren()->forAll(function (ElementInterface $child) use ($data, $accessor) {
            if (null !== $propertyPath = $child->getPropertyPath(true)) {
                if ($accessor->isReadable($data, $propertyPath)) {
                    $value = $accessor->getValue($data, $propertyPath);
                    $child->setValue($value);
                }
            }
        });
    }
}
