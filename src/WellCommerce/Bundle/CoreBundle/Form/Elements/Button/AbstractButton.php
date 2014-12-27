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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements\Button;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\CoreBundle\Form\Elements\AbstractNode;

/**
 * Class AbstractButton
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractButton extends AbstractNode
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefined([
            'icon'
        ]);

        $resolver->setAllowedTypes([
            'icon' => 'icon'
        ]);
    }

    public function getValue()
    {
        return '';
    }
} 