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

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\OptionInterface;

/**
 * Class LoadedEventHandler
 *
 * @package WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\EventHandler
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadedEventHandler extends AbstractEventHandler implements EventHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getFunctionName()
    {
        return 'loaded';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'function',
        ]);

        $resolver->setDefaults([
            'function' => OptionInterface::GF_NULL,
        ]);

        $resolver->setAllowedTypes([
            'function' => ['string'],
        ]);
    }
} 