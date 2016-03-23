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

namespace WellCommerce\Component\Form\DataMapper;

use WellCommerce\Component\Form\Elements\ElementCollection;
use WellCommerce\Component\Form\Elements\ElementInterface;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class RequestDataMapper
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class RequestDataMapper extends AbstractDataMapper
{
    /**
     * Maps request data to form
     *
     * @param FormInterface $form
     */
    public function mapDataToForm(FormInterface $form)
    {
        $this->mapRequestDataToElementCollection($this->data, $form->getChildren());
    }

    /**
     * Maps data to single element
     *
     * @param mixed            $data
     * @param ElementInterface $child
     */
    protected function mapRequestDataToElement($data, ElementInterface $child)
    {
        $child->setValue($data);
        $children = $child->getChildren();

        if ($children->count()) {
            $this->mapRequestDataToElementCollection($data, $children);
        }
    }

    /**
     * Recursively maps data to children
     *
     * @param mixed             $data
     * @param ElementCollection $children
     */
    protected function mapRequestDataToElementCollection($data, ElementCollection $children)
    {
        $children->forAll(function (ElementInterface $element) use ($data) {
            $propertyPath = $this->getPropertyPathAsIndex($element);
            if (array_key_exists($element->getName(), $data)) {
                $values = $this->propertyAccessor->getValue($data, $propertyPath);
                $this->mapRequestDataToElement($values, $element);
            }
        });
    }

    /**
     * @param ElementInterface $element
     *
     * @return string
     */
    private function getPropertyPathAsIndex(ElementInterface $element)
    {
        return sprintf('[%s]', $element->getName());
    }
}
