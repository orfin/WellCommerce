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
use WellCommerce\Component\Form\Elements\ElementInterface;

/**
 * Class RichTextEditor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RichTextEditor extends TextArea implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'advanced',
        ]);

        $resolver->setDefaults([
            'advanced' => true,
        ]);

        $resolver->setAllowedTypes('advanced', 'bool');
    }
}
