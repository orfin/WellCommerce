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

namespace WellCommerce\Bundle\FormBundle\Elements\Fixed;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\FormBundle\Elements\Attribute;
use WellCommerce\Bundle\FormBundle\Elements\AttributeCollection;
use WellCommerce\Bundle\FormBundle\Elements\ElementInterface;

/**
 * Class StaticText
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class StaticText extends AbstractFixedField implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'text',
        ]);

        $resolver->setDefaults([
            'name'  => '',
            'text'  => '',
            'class' => '',
        ]);

        $resolver->setAllowedTypes([
            'text'  => 'string',
            'class' => 'string',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesCollection(AttributeCollection $collection)
    {
        parent::prepareAttributesCollection($collection);
        $collection->add(new Attribute('sText', $this->getOption('text')));
    }
}
