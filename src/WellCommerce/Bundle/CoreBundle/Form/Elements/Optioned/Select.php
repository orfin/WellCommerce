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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements\Optioned;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;

/**
 * Class Select
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Select extends AbstractOptionedField implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefined([
            'selector',
            'css_attribute',
            'addable',
            'onAdd',
            'add_item_prompt',
        ]);

        $resolver->setAllowedTypes([
            'selector'        => 'string',
            'css_attribute'   => 'string',
            'addable'         => 'bool',
            'onAdd'           => 'string',
            'add_item_prompt' => 'string',
        ]);
    }

}
