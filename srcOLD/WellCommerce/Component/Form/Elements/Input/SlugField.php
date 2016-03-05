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

namespace WellCommerce\Component\Form\Elements\Input;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\Form\Elements\Attribute;
use WellCommerce\Component\Form\Elements\AttributeCollection;
use WellCommerce\Component\Form\Elements\ElementInterface;

/**
 * Class TextField
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SlugField extends TextField implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'translatable_id',
            'name_field',
            'generate_route',
        ]);

        $resolver->setDefaults([
            'class' => 'sluggable'
        ]);

        $resolver->setAllowedTypes('name_field', ElementInterface::class);
        $resolver->setAllowedTypes('generate_route', 'string');

        $resolver->setNormalizer('name_field', function (Options $options, ElementInterface $value) {
            return $value->getName();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesCollection(AttributeCollection $collection)
    {
        parent::prepareAttributesCollection($collection);
        $collection->add(new Attribute('sTranslatableId', $this->getOption('translatable_id')));
        $collection->add(new Attribute('sNameField', $this->getOption('name_field')));
        $collection->add(new Attribute('sGenerateRoute', $this->getOption('generate_route')));
    }
}
