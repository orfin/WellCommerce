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

namespace WellCommerce\Bundle\FormBundle\Elements\Input;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\FormBundle\Elements\Attribute;
use WellCommerce\Bundle\FormBundle\Elements\AttributeCollection;
use WellCommerce\Bundle\FormBundle\Elements\ElementInterface;

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
            'class' => 'sluggable',
        ]);

        $resolver->setAllowedTypes([
            'name_field'     => 'WellCommerce\Bundle\FormBundle\Elements\ElementInterface',
            'generate_route' => 'string',
        ]);

        $fieldNormalizer = function (Options $options, ElementInterface $value) {
            return $value->getName();
        };

        $resolver->setNormalizers([
            'name_field' => $fieldNormalizer,
        ]);
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
