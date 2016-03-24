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

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\Form\Elements\Attribute;
use WellCommerce\Component\Form\Elements\AttributeCollection;
use WellCommerce\Component\Form\Elements\ElementInterface;

/**
 * Class TextArea
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TextArea extends TextField implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'rows',
            'cols',
        ]);

        $resolver->setDefaults([
            'rows' => 20,
            'cols' => 50,
        ]);

        $resolver->setAllowedTypes('rows', 'int');
        $resolver->setAllowedTypes('cols', 'int');
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesCollection(AttributeCollection $collection)
    {
        parent::prepareAttributesCollection($collection);
        $collection->add(new Attribute('iCols', $this->getOption('cols')));
        $collection->add(new Attribute('iRows', $this->getOption('rows')));
    }
}
