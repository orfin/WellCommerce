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

namespace WellCommerce\Bundle\CoreBundle\Form\DataMapper;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyPathInterface;
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementCollection;
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;
use WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface;

/**
 * Class DataMapper
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class DataMapper implements DataMapperInterface
{
    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected $propertyAccessor;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
    }

    public function mapDataToForm($data, FormInterface $form)
    {
        $this->mapDataToElementCollection($data, $form->getChildren());
    }

    public function mapFormToData(FormInterface $form, $data)
    {
    }

    /**
     * Maps data to single element
     *
     * @param ElementInterface $child
     */
    protected function mapDataToElement($data, ElementInterface $child)
    {
        $this->setDefaultElementValue($data, $child);

        $children = $child->getChildren();

        if ($children->count()) {
            $this->mapDataToElementCollection($data, $children);
        }
    }

    /**
     * Maps data using recursion to all children
     *
     * @param ElementCollection $children
     */
    protected function mapDataToElementCollection($data, ElementCollection $children)
    {
        foreach ($children->all() as $child) {
            $this->mapDataToElement($data, $child);
        }
    }

    /**
     * Sets value for element
     *
     * @param ElementInterface $element
     */
    protected function setDefaultElementValue($data, ElementInterface $element)
    {
        if ($element->hasPropertyPath()) {
            $propertyPath = $element->getPropertyPath();
            if ($this->propertyAccessor->isReadable($data, $propertyPath)) {
                $value = $this->getValueFromData($propertyPath, $data);
                if (null === $value) {
                    $value = $this->getDefaultValue($element);
                }

                if ($element->hasTransformer()) {
                    $transformer = $element->getTransformer();
                    $value       = $transformer->transform($value);
                }

                $element->setValue($value);
            }
        }
    }

    /**
     * Returns default value for element
     *
     * @param ElementInterface $element
     *
     * @return mixed|null
     */
    protected function getDefaultValue(ElementInterface $element)
    {
        if ($element->hasOption('default')) {
            return $element->getOption('default');
        }

        return null;
    }

    /**
     * @param PropertyPathInterface $propertyPath
     * @param                       $data
     *
     * @return mixed|null
     */
    protected function getValueFromData(PropertyPathInterface $propertyPath, $data)
    {
        return $this->propertyAccessor->getValue($data, $propertyPath);
    }
}