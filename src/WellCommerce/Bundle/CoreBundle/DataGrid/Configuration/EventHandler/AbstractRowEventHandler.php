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

namespace WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\EventHandler;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbstractRowEventHandler
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractRowEventHandler extends AbstractEventHandler
{
    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'row_action',
            'context_action',
            'route',
        ]);

        $resolver->setDefaults([
            'row_action'     => false,
            'context_action' => false,
            'route'          => false,
        ]);

        $resolver->setAllowedTypes([
            'row_action'     => ['bool', 'string'],
            'context_action' => ['bool', 'string'],
            'route'          => ['bool', 'string'],
        ]);
    }
}
