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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\PropertyAccess\PropertyPath;

/**
 * Class FieldsetRepeatable
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FieldsetRepeatable extends Fieldset implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolverInterface $resolver)
    {
        parent::configureAttributes($resolver);

        $resolver->setRequired([
            'repeat_min',
            'repeat_max',
        ]);

        $resolver->setAllowedTypes([
            'repeat_min' => ['numeric'],
            'repeat_max' => ['numeric'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesJs()
    {
        return [
            $this->formatAttributeJs('name', 'sName'),
            $this->formatAttributeJs('label', 'sLabel'),
            $this->formatRepeatableJs(),
            $this->formatDependencyJs(),
            'aoFields: [' . $this->renderChildren() . ']'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function setPropertyPath()
    {
        $this->attributes['property_path'] = new PropertyPath($this->getName());
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaults($defaultData)
    {
        $accessor = $this->getPropertyAccessor();
        if (null !== $this->getPropertyPath() && $accessor->isReadable($defaultData, $this->getPropertyPath())) {
            $values = $accessor->getValue($defaultData, $this->getPropertyPath());
            if ($this->hasTransformer()) {
                $values = $this->getTransformer()->transform($values);
            }
            $this->_value = 1;
            foreach ($this->children as $child) {
                echo $child->getPropertyPath() . PHP_EOL;
                $this->populate(1111);
            }
        }

        $this->_value = 1;
    }
}
