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

namespace WellCommerce\Component\Form\Elements\Button;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\Form\Elements\Fixed\AbstractFixedField;

/**
 * Class AbstractButton
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractButton extends AbstractFixedField
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'icon' => '',
        ]);

        $resolver->setAllowedTypes('icon', 'string');
    }

    public function getValue()
    {
        return '';
    }
}
