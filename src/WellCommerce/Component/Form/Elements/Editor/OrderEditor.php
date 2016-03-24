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
namespace WellCommerce\Component\Form\Elements\Editor;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\Form\Elements\AbstractField;
use WellCommerce\Component\Form\Elements\Attribute;
use WellCommerce\Component\Form\Elements\AttributeCollection;
use WellCommerce\Component\Form\Elements\ElementInterface;

/**
 * Class OrderEditor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderEditor extends AbstractField implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'on_change',
            'on_before_change',
            'load_products_route',
            'repeat_min',
            'repeat_max',
        ]);

        $resolver->setAllowedTypes('on_change', 'string');
        $resolver->setAllowedTypes('on_before_change', 'string');
        $resolver->setAllowedTypes('load_products_route', 'string');
        $resolver->setAllowedTypes('repeat_min', 'numeric');
        $resolver->setAllowedTypes('repeat_max', 'numeric');
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesCollection(AttributeCollection $collection)
    {
        parent::prepareAttributesCollection($collection);
        $collection->add(new Attribute('fOnChange', $this->getOption('on_change'), Attribute::TYPE_FUNCTION));
        $collection->add(new Attribute('fOnBeforeChange', $this->getOption('on_before_change'), Attribute::TYPE_FUNCTION));
        $collection->add(new Attribute('sLoadProductsRoute', $this->getOption('load_products_route'), Attribute::TYPE_STRING));
        $collection->add(new Attribute('oRepeat', $this->prepareRepetitions(), Attribute::TYPE_ARRAY));
    }
}
