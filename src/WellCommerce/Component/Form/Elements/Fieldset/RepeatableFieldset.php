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

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\Form\Elements\Attribute;
use WellCommerce\Component\Form\Elements\AttributeCollection;

/**
 * Class RepeatableFieldset
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class RepeatableFieldset extends AbstractFieldset implements FieldsetInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'repeat_min',
            'repeat_max',
        ]);

        $resolver->setAllowedTypes('repeat_min', 'numeric');
        $resolver->setAllowedTypes('repeat_max', 'numeric');
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesCollection(AttributeCollection $collection)
    {
        parent::prepareAttributesCollection($collection);
        $collection->add(new Attribute('oRepeat', $this->prepareRepetitions(), Attribute::TYPE_ARRAY));
    }
}
